## Name:

**Dapphp\PhpZipUtils** - PHP classes for efficiently reading, writing, and 
modifying ZIP files using native PHP code

## Version:

**1.0**

## Author:

Drew Phillips <drew@drew-phillips.com>

## Requirements:

* PHP 5.3 or greater
* PHP zlib extension

## Description:

**PhpZipUtils** is a set of PHP classes for reading and writing ZIP files
without any ZIP related PHP extensions.  Currently, the only dependency is zlib
for GZIP compression and or BZIP for reading bzip compressed ZIP files.

Some highlights are:

- Read ZIP files from a string (memory)
- Read ZIP files from disk without reading the whole file into memory
- Buffered (for efficiency) or non-buffered reading
- Extract the contents of a ZIP file to a directory
- Create zip files by adding files from disk or strings
- Modify existing zip files (add/modify/remove files)
- Read and write PKZip encrypted archives (TODO: support AES extensions)
- Similar interface to PHP's ZipArchive class
- Ability to easily open a ZIP file and only extract the desired files

## Examples:

More documentation coming soon.  See the tests/ directory for various examples.

## TODO:

- Get WinZip AES decryption working
- Check for ZIP64 extensions
- Modify addFile() method to store the path to the file until the ZIP is written
rather than reading the contents into memory when addFile() is called

## Copyright:

    Copyright (c) 2015 Drew Phillips
    All rights reserved.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

    - Redistributions of source code must retain the above copyright notice,
      this list of conditions and the following disclaimer.
    - Redistributions in binary form must reproduce the above copyright notice,
      this list of conditions and the following disclaimer in the documentation
      and/or other materials provided with the distribution.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
    AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
    IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
    ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
    LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
    CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
    SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
    INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
    CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
    ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
    POSSIBILITY OF SUCH DAMAGE.
