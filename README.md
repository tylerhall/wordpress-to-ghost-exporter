# Export / Convert WordPress 5.x to Ghost 2.x

## Motivation

I recently migrated [my twelve year-old WordPress blog](https://tyler.io) to [Ghost](https://ghost.org). I've always been very happy with WordPress, I just wanted to learn more about the Node ecosystem and decided to give Ghost a try.

Installation was easy enough, but when I learned that Ghost doesn’t actually offer an up-to-date WordPress importer I almost quit right there. The whole tone of the Ghost website rubs me the wrong way - and the fact that they can’t spend a day writing an importer for the most popular CMS on the web? It all strikes me a bit amateurish.

Anyway, I really wanted to give it a try, so I took an hour one evening and wrote this script to export my WordPress database to Ghost’s latest JSON backup format.

## Assumptions

I wrote this script to convert _my_ WordPress installation - a single author blog written primarily in HTML and Markdown that uses post categories (not tags). If you have a more complicated WP setup, this probably won’t work for you, but you’re welcome to adapt the script to your needs and submit improvements.

Here’s what I’m assuming about your WordPress setup:

- Only one WP author.
- WP posts are either Markdown or HTML.
- All posts are written with Classic Editor - I have no idea what might happen if you run this script against posts edited with Gutenberg.

## Running the Script

1. Fill out the MySQL database settings at the top of the PHP script.
2. Fill out the name and email address of the Ghost author you would like the exported posts to be assigned to.
3. You can then either run the script in a web browser and copy/paste the output into a text file, or you can run `php wp-ghost-export.php > ghost.json`.
4. Import `ghost.json` into your Ghost installation via the admin area.

## Contributions

Like I said above, this script is _very_ bare-bones and was designed for my specific use case. You’re welcome to file bugs/feature requests or - even better - submit a pull request with your own improvements.
