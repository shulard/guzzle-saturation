Socket Saturation
=================

I currently work with distributed databases which use HTTP requests to perform actions (like ElasticSearch).

On a server, I receive an error about cURL which can't assign the request address:

```
[curl] 7: Failed to connect to 127.0.0.1: Can't assign requested address [url] http://127.0.0.1:9200
````

This error was thrown directly by the PHP cURL extension and not by my code... After some search, I found that it is possible my code take all socket possibilities on the system and then the error appear.

For this project I use [Guzzle](http://guzzlephp.org/) as my favourite PHP Client but it seems to have a little problem with a lot of quick calls...

I create this repo to present the problem and illustrate with some stats.

## Licence

Copyright (c) 2013 **Stéphane HULARD**

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
