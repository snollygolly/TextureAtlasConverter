<?php
$VERSION = 1;

if (isset($argv)) {
  //get the file name
  $filename = $argv[1];
  //see if that file exists
  if (file_exists($filename)) {
      $xml = simplexml_load_file($filename);
      //the xml is now imported
      $json = convertXMLToJSONHash($xml);
      $new_filename = explode(".", $filename)[0] . ".json";
      logMsg("{$json->meta->sprites} textures processed successfully with {$json->meta->app} version {$json->meta->version}");
      file_put_contents($new_filename, json_encode($json));
      logMsg("Saved to {$new_filename}");
  } else {
    logMsg("No file exists named: {$filename}");
    die();
  }
}
else {
  logMsg("No input file name provided");
  die();
}
die();

function convertXMLToJSONHash($xml){
  $json = new stdClass();
  //build out the frames obj (contains all the images)
  $json->frames = new stdClass();
  //build out the meta object (just info about this program)
  $json->meta = writeJSONMeta();
  //loop through all subtextures
  $i = 0;
  foreach ($xml->SubTexture as $frame){
    //get the attributes for each XML node
    $attrs = $frame->attributes();
    //make the right object, JSON arr would differ here
    $json->frames->{$attrs["name"]} = new stdClass();
    //make the frame object
    $frame_obj = new stdClass();
    $frame_obj->x = intval($attrs["x"]);
    $frame_obj->y = intval($attrs["y"]);
    $frame_obj->w = intval($attrs["width"]);
    $frame_obj->h = intval($attrs["height"]);
    //set the frame object
    $json->frames->{$attrs["name"]}->frame = $frame_obj;

    //make the sprite source object
    $sprite_obj = new stdClass();
    $sprite_obj->x = 0;
    $sprite_obj->y = 0;
    $sprite_obj->w = $frame_obj->w;
    $sprite_obj->h = $frame_obj->h;
    //set the sprite source object
    $json->frames->{$attrs["name"]}->spriteSourceSize = $sprite_obj;

    //make the source size object
    $source_obj = new stdClass();
    $source_obj->w = $frame_obj->w;
    $source_obj->h = $frame_obj->h;
    //set the sprite source object
    $json->frames->{$attrs["name"]}->sourceSize = $source_obj;

    //add some more stuff that may or may not matter
    $json->frames->{$attrs["name"]}->rotated = false;
    $json->frames->{$attrs["name"]}->trimmed = false;

    //make the pivot object
    $pivot_obj = new stdClass();
    $pivot_obj->x = 0.5;
    $pivot_obj->y = 0.5;
    $json->frames->{$attrs["name"]}->rotated = false;
    $i++;
  }
  $json->meta->sprites = $i;
  //get root attributes
  $attrs = $xml->attributes();
  $json->meta->image = (string)$attrs["imagePath"];
  return $json;
}

function writeJSONMeta(){
  global $VERSION;
  $meta = new stdClass();
  $meta->app = "TextureAtlasConverter";
  $meta->version = $VERSION;
  return $meta;
}

function logMsg ($message){
  echo "{$message}\n";
}
?>
