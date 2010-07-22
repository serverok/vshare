    </div> <!-- main -->

    <div id="footer">

        <div class="clearfix center">
            {insert name=advertise adv_name='banner_bottom'}
        </div>

        <div class="menu_footer clearfix">
            <a href="{$base_url}/pages/about.html">About Us</a> &nbsp;&nbsp; |&nbsp;&nbsp;
            <a href="{$base_url}/pages/help.html">Help</a>&nbsp;&nbsp; |&nbsp;&nbsp;
            <a href="{$base_url}/pages/advertise.html">Advertise</a>&nbsp;&nbsp; |&nbsp;&nbsp;
            <a href="{$base_url}/pages/terms.html">Terms of Use</a>&nbsp;&nbsp; |&nbsp;&nbsp;
            <a href="{$base_url}/pages/privacy.html">Privacy Policy</a>
        </div>

        <div class="copy">
            Copyright &copy; {$smarty.now|date_format:"%Y"} {$site_name}. All rights reserved.<br />
            <!--
            REMOVING THE LINE BELOW CONSTITUTES A VIOLATION
            OF YOUR LICENSE AGREEMENT AND WILL RESULT IN
            SIGNIFICANT PENALITIES IF REMOVED.
            -->
            Powered by <a class="copy" href="http://buyscripts.in/youtube_clone.html" target="_blank">vShare</a>
        </div>

    </div> <!-- footer -->

</div> <!-- wrapper -->
<div class="quicklist_box" id="quicklist_box"></div>
</body>
</html>
<script language="JavaScript" type="text/javascript">
var baseurl='{$base_url}';
</script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/vshare.js"></script>
<script language="JavaScript" type="text/javascript" src="{$base_url}/js/video_queue.js"></script>
{$html_extra}
