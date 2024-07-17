# WP CLI Media Cleaner

A CLI based media cleaner for WordPress

## Installation

Clone the repository into your WordPress plugins folder and activate the plugin.

```bash
git clone https://github.com/calvinrodrigues500/wp-cli-media-cleaner.git
```
## Usage

##### Scan unused media files

```bash
wp media-cleaner scan --report=<true|false>
```
Use the ```--report``` flag to generate a report file in ```.txt``` format.
The generated report file will be stored in the media cleaner plugin folder.

##### Delete unused media files
This command will delete all the unused media files found on the WordPress site.

```bash
wp media-cleaner delete
```

##### For more details about the CLI command

```bash
wp media-cleaner --help
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.
