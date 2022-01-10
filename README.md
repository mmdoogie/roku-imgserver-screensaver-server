# roku-imgserver-screensaver-server
Server component to pair with [roku-imgserver-screensaver](https://github.com/mmdoogie/roku-imgserver-screensaver).

# Tool Requirements
Needs a webserver capable of serving PHP.  Also need imagemagick's convert command available.

# Setup
1. Host the `imgserver.php` file on the webserver along with the `priv/do-fetch` script and `priv/fetchList` file.
2. Set up config file or .htaccess or permissions such that `priv` contents are not externally accessible.
3. Update `imgserver.php` setting the base path at the top of the file by updating the line `$basePath = "/var/www/html/imgserver";`.
4. Update `priv/do-fetch` setting the base path at the top of the file by updating the line `OUTPATH="/var/www/html/imgserver"`.
5. Set up the images to serve in the `priv/fetchList` file.  Each line should consist of `Description:URL`

# Grafana Version
To show Grafana dashboards, first install the Grafana Image Renderer plugin. Then, use the `priv/do-fetch-grafana` script instead.  You'll need to update the few variables at the top of the file adding the server path, API key, etc.

In the `fetchList` if the URL starts with http or https then it'll be treated as a normal image.

For dashboards, provide just the path portion of the url.  To get the proper path, open the dashboard in your browser as normal and copy the path, for example `/grafana/d/abcdefghi/3d-printer` and add `/render` before the `/d/` to get `/grafana/render/d/abcdefghi/3d-printer` to put in the `fetchList`.
