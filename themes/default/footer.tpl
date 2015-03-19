    </div> <!-- main -->

    <div class="clearfix">&nbsp;</div>

    <footer class="row">

        <div class="clearfix center">
            {insert name=advertise adv_name='banner_bottom'}
        </div>

        <ul class="list-inline text-center">
            <li><a class="btn" href="{$base_url}/pages/about.html">About Us</a></li>
            <li><a class="btn" href="{$base_url}/pages/help.html">Help</a></li>
            <li><a class="btn" href="{$base_url}/pages/advertise.html">Advertise</a></li>
            <li><a class="btn" href="{$base_url}/pages/terms.html">Terms of Use</a></li>
            <li><a class="btn" href="{$base_url}/pages/privacy.html">Privacy Policy</a></li>
        </ul>

        <div class="copy text-center text-muted">
            Copyright &copy; {$smarty.now|date_format:"%Y"} {$site_name}. All rights reserved.<br />
            <!--
            REMOVING THE LINE BELOW CONSTITUTES A VIOLATION
            OF YOUR LICENSE AGREEMENT AND WILL RESULT IN
            SIGNIFICANT PENALITIES IF REMOVED.
            -->
            Powered by <a class="copy" href="http://buyscripts.in/youtube_clone.html" target="_blank">vShare</a>
        </div>

    </footer>

</div> <!-- container -->
<div class="quicklist_box" id="quicklist_box"></div>
<script src="{$base_url}/js/bootstrap.min.js"></script>
</body>
</html>
<script language="JavaScript" type="text/javascript">
var baseurl='{$base_url}';
</script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/vshare.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_queue.js"></script>
{$html_extra}
