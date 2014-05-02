<h1>Add FLV URL</h1>

{if $success eq 0}

    <!-- Individual YUI CSS files -->
    <link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/tabview/assets/skins/sam/tabview.css">
    <!-- Individual YUI JS files -->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/connection/connection-min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/element/element-beta-min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/yui/2.6.0/build/tabview/tabview-min.js"></script>

    <div class="yui-skin-sam" style="margin: 4em auto;border:1px solid #cccccc;padding:4em;">

        <form action="video_add_flv_2.php" method="post" enctype="multipart/form-data">

            <div id="media_form" class="yui-navset">
                <ul class="yui-nav">
                    <li class="selected">
                        <a href="#media_flv"><em>URL of FLV</em></a>
                    </li>
                    <li>
                        <a href="#media_embed"><em>Embed Code</em></a>
                    </li>
                </ul>
                <div class="yui-content">
                    <div id="media_flv">
                    <p>Enter URL: <input type="text" name="flv_url" size="60" /></p>
                    </div>

                    <div id="media_embed">
                    <p>
                        Embed Code:<br />
                        <textarea name="embed_code" cols="40" rows="4"></textarea>
                    </p>
                    </div>
                </div>
            </div>

            <br />

            <div id="image_form" class="yui-navset">
                <ul class="yui-nav">
                    <li class="selected">
                        <a href="#remote_image"><em>Image URL</em></a>
                    </li>
                    <li>
                        <a href="#local_image"><em>Image From Your Computer</em></a>
                    </li>
                </ul>
                <div class="yui-content">
                    <div id="remote_image">
                        Image 1 Url: <input name="embedded_code_image[]" size="60" type="text" /><br />
                        Image 2 Url: <input name="embedded_code_image[]" size="60" type="text" /><br />
                        Image 3 Url: <input name="embedded_code_image[]" size="60" type="text" /><br />
                    </div>

                    <div id="local_image">
                        Image 1 : <input name="embedded_code_image_local[]" size="40" type="file" /><br />
                        Image 2 : <input name="embedded_code_image_local[]" size="40" type="file" /><br />
                        Image 3 : <input name="embedded_code_image_local[]" size="40" type="file" /><br />
                    </div>
                </div>
            </div>

            <br />

            <script type="text/javascript">
                var tabView = new YAHOO.widget.TabView('media_form');
                var tabView = new YAHOO.widget.TabView('image_form');
            </script>

            <input type="submit" name="submit" value="Upload" class="btn btn-primary" />

        </form>

    </div>

{/if}