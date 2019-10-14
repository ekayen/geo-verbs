# Georgian verbal morphology 

This repo contains code for an FST-based morphological analyzer of Georgian verbs. It's coverage is incomplete.

Uses Xerox's xfst system.

## Setup

1. Clone repo:

`git clone http://github.com/ekayen/geo-verbs`

2. Download xfst from here: https://web.stanford.edu/~laurik/fsmbook/home.html
3. Place the following binary files in the top level of this repository: 
```
lexc.exe
lookup.exe
tokenize.exe
twolc.exe
xfst.exe
```

The analyzer can then be used either via the xfst command-line tool or the html-based interface defined in `geo-verbs.html`.
