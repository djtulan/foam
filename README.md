# foam = Fomantic & Ampache

foam is a web player frontend for Ampache using the Fomantic UI CSS framework. It is mostly PHP, CSS and HTML and designed to be simple and portable.

The player is made with js and uses the howler audio library.

## Core Features

- Browse by recently played, newest added, most frequent, favourited and random album views.
- Browse by artists or tracks with filters.
- Browse, create and add to playlists.
- Play or shuffle albums.
- Add individual songs or albums to current play queue.
- View current queue via pulldown list. Jump ahead or back in queue via clickable list.
- Top of screen micro player with transport controls, mini art thumbnail and volume, mute controls.
- Favourite or unfavourite individual tracks or albums.
- Download links for individual tracks.
- Smart search bar for album, artist and song search.

## Future Roadmap Features (after full stable release)

- Advanced dual pipeline player with mixing capabilities.
- Mix crates, advanced tagging and filters.
- Waveform and bpm analysis.
- Volume normalisation.
- Auto mixing/crossfading.
- Streaming and radio.

![Overview](/img/screenshot_pre-release_wip2_sml.png)

## Installation
Simply drop everything into your public html directory of your PHP enabled web server and away you go. No building should be necessary as it is designed to be self contained.

You need an [Ampache](https://github.com/ampache/ampache) server somewhere.

Some limited options can be found in config/foam.conf.php which sets a few php variables.

Note: During pre-release authentication to Ampache is hard coded in this config file for ease of testing purposes. Because of this you should not leave your testing foam site exposed to the public as anyone will be able to access it, use your bandwidth and download your media.

The next version will change this to use browser authentication.

## TODO
- Early days - still building the base functionality to get to a working release stage.

#### _Working_
- Recent, newest, frequent, favourites and random albums views.
- Single album view with track listing after clicking on an album
- Play track in album view by clicking track title or track number
- DL link in track listing
- pause/play toggle, Previous/Next skip buttons in microplayer
- mute/unmute volume button in microplayer
- volume slider
- links to artist from track listing (or anywhere artist name appears)
- Artist all tracks view
- Artists all albums view
- Playback timer and slider position update during playback.
- Album play and shuffle buttons and functions
- Album view and artist track views now create a queue when played.
- iFrame to separate micro player from content browsing
- Queue pulldown from micro player with clickable tracks

#### _Not Yet Working_
- Browser authentication for Ampache with cookies
- Track seeking via slider
- All artists view, all tracks view, playlists view
- Search from top bar
- pagination for results
- Queue manipulation (add to queue, re-order)
- Adding or removing favourites (tagged)

## Contributions
Once I have a working release then contributions and suggestions always welcome.

## Testing
Testing on Chrome (Windows and Linux) during initial development.
- Ampache: dev (testing 5.0)
- Apache: 2.4.41
- PHP: 7.4.3

## Acknowledgements & Dependencies
- Inspired by the subsonic player [subplayer](https://github.com/peguerosdc/subplayer) - a really nice looking web player for subsonic.
- Using [Fomantic UI](https://github.com/fomantic/Fomantic-UI) components (v2.8.7 included).
- Using [howler.js](https://github.com/goldfire/howler.js) audio library for media playback (In HTML mode for better FLAC playback).
- Fomantic (Semantic) UI is still dependent on jquery (pulled from CDN - no need to include it).
- Of course you need a backend [Ampache](https://github.com/ampache/ampache) server.
- And a PHP enabled webserver (PHP version 7.4+ recommended).

## License

Licensed under the GNU General Public License v3.0.
