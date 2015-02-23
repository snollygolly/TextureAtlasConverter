TextureAtlasConverter
===

I made this project to convert XML texture atlases to JSON for use in [pixi.js](http://www.pixijs.com)

I downloaded [Kenney's](http://www.kenney.nl/) numerous game asset packages (which I highly recommend), but all of them came with only an .XML texture atlas.  If you have all the separate PNGs, you can generate your own with [TexturePacker](https://www.codeandweb.com/texturepacker), but that's kind of a pain.  I made this script to do it for me.

Currently it accepts an .XML texture atlas file, and outputs a .JSON texture atlas file (I modeled it off of TexturePacker's "JSON Hash" output).

It was built with PHP 5.5.14

Usage:
```
php convert.php TextureAtlas.xml
```

and it will output a JSON in the same folder.  Easy peasy!
