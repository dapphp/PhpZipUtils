<?php

namespace Dapphp\PhpZipUtils;

use Dapphp\PhpZipUtils\Crc32;

require_once 'Crc32.php';

/**
 * Zip crypto class for PKZip encryption/decryption
 *
 * Note: These methods are static for performance reasons
 *
 */
class ZCrypt
{
    /**
     * Initialize zip encryption keys
     *
     * @param array $keys Array for holding key state
     * @param string $password The password for encryption/decryption
     */
    public static function initEncryptionKeys(array &$keys, $password)
    {
        /*
        6.1.5 Initializing the encryption keys

        Key(0) <- 305419896
        Key(1) <- 591751049
        Key(2) <- 878082192

        loop for i <- 0 to length(password)-1
        update_keys(password(i))
        end loop
        */

        $keys = array(0x12345678, 0x23456789, 0x34567890);
        $len = strlen($password);

        for ($i = 0; $i < $len; ++$i) {
            self::updateEncryptionKeys($keys, ord($password{$i}));
        }
    }

    /**
     * Update encryption keys from file input
     *
     * @param array $keys The encryption keys
     * @param string $byte Byte from file to update keys
     */
    public static function updateEncryptionKeys(array &$keys, $byte)
    {
        /*
        Where update_keys() is defined as:

        update_keys(char):
        Key(0) <- crc32(key(0),char)
        Key(1) <- Key(1) + (Key(0) & 000000ffH)
        Key(1) <- Key(1) * 134775813 + 1
        Key(2) <- crc32(key(2),key(1) >> 24)
        end update_keys
        */

        $keys[0] = Crc32::updateCrc32($keys[0], $byte);
        $keys[1] = $keys[1] + ($keys[0] & 0xff);
        $keys[1] = ($keys[1] * 134775813 + 1) & 0xffffffff;
        $keys[2] = Crc32::updateCrc32($keys[2], $keys[1] >> 24);
    }

    /**
     * Encrypt a byte of data and update keys
     *
     * @param array $keys Encryption keys
     * @param string $char character to encrypt
     * @param unknown $temp Temporary encryption value
     */
    public static function zEncode(array &$keys, &$char, &$temp)
    {
        #define zencode(c,t)  (t=decrypt_byte(__G), update_keys(c), t^(c))

        $temp = ($keys[2] & 0xffff) | 2;
        $temp = ((($temp * ($temp ^ 1)) >> 8) & 0xff);

        self::updateEncryptionKeys($keys, $char);

        $char ^= $temp;
    }

    /**
     * Decrypt a byte of data and update keys
     *
     * @param array $keys Encryption keys
     * @param string $char Character to decrypt
     */
    public static function zDecode(array &$keys, &$char)
    {
        // implicit decrypt_byte() -> defined as:
        // local unsigned short temp
        // temp <- Key(2) | 2
        // decrypt_byte <- (temp * (temp ^ 1)) >> 8
        $temp = ($keys[2] & 0xffff) | 2;
        $temp = ((($temp * ($temp ^ 1)) >> 8) & 0xff);

        self::updateEncryptionKeys($keys, $char ^= $temp);
    }
}
