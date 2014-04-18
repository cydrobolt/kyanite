<?php
@(include('config.php')) or header('Location:setup.php');
require_once 'headerpage.php';
require_once('version.php');
?>

<h1>About Kyanite</h1>
<br>
<dl>Build Information
    <dt>Version: <?php require_once('req.php');
echo $version; ?>
    <dt>Release date: <?php echo $reldate; ?>
    <dt>App Build : <?php echo $wsn . " by " . $wsa . " on " . $wsb ?>
    <dt>
</dl>
<br><p>Kyanite is an open source user analytics application. Learn more at <a href='https://github.com/Cydrobolt/kyanite'>https://github.com/Cydrobolt/kyanite</a>
    <br>Kyanite is licensed under the MIT License.</p>
<div>
    The MIT License (MIT)
    <br>
    Copyright (c) 2014 Kyanite Project & <a href='//cydrobolt.com'>Cydrobolt</a>
    <br>
    Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
    <br>
    The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
    <br>
    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
</div>
<?php
require_once 'footerpage.php';
?>