<?php
// function formatBytes(bytes,decimals) {
//    if(bytes == 0) return '0 Bytes';
//    var k = 1024,
//        dm = decimals || 2,
//        sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'],
//        i = Math.floor(Math.log(bytes) / Math.log(k));
//    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
// }

function formatBytes($bytes, $dm = 2) {
  if ($bytes == 0) return '0B';
  $k = 1000;
  $sizes = ["B", "KB", "MB", "GB", "TB", "PB", "EB", "ZB", "YB"];
  $i = floor(log($bytes) / log($k));
  return round($bytes / pow($k, $i), $dm) . $sizes[$i];
}

function formatNum($num, $dm = 2) {
  $k = 1000;
  if ($num < $k) return $num;
  $sizes = ["", "K", "M", "B", "T", "P", "E", "Z", "Y"];
  $i = floor(log($num) / log($k));
  return round($num / pow($k, $i), $dm) . $sizes[$i];
}

function remove_scripts($html) {
  try {
    $doc = new DOMDocument();
    $doc->loadHTML("<html>$html</html>");
    $scripts = $doc->getElementsByTagName('script');
    $length = $scripts->length;

    for ($i = 0; $i < $length; $i ++) {
      $scripts->item($i)->parentNode->removeChild($scripts->item($i));
    }

    return $doc->saveHTML();
  } catch (\Exception $e) {
    return "";
  }
}
