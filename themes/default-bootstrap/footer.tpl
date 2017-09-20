{if !isset($content_only) || !$content_only}
</div><!-- #center_column -->
{if isset($right_column_size) && !empty($right_column_size)}
    <div id="right_column" class="col-xs-12 col-sm-{$right_column_size|intval} column">{$HOOK_RIGHT_COLUMN}</div>
{/if}
</div><!-- .row -->
</div><!-- #columns -->
</div><!-- .columns-container -->

<div class="panel-footer">
    <div class="container xs-padding-none">
        <div class="col-sm-4 text-muted">Copyright &copy; 2016 - Design and develop by VisitorTrip</div>
        <div class="col-sm-4 text-muted footer-label">
            <a href="{$base_uri}"><span>Home</span></a>&nbsp;|
            <a href="{$base_uri}info/about-visitortrip"><span>About Us</span></a>&nbsp;|
            <a href="{$base_uri}contact-us"><span>Contact Us</span></a>&nbsp;|
            <a href="{$base_uri}info/privacy-policy"><span>Privacy policy</span></a>
        </div>
        <div class="col-sm-4 text-muted">
            <div class="col-sm-6" style="margin: 0;padding: 0;">
                <div class="fb-like" data-href="https://facebook.com/visitortrip" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
            </div>
            <div class="col-sm-6 gplus" style="margin: 0;padding: 0;">
                <div class="g-plusone" data-size="small" data-annotation="inline" data-width="200"></div>
            </div>
        </div>
    </div>
</div>








{*{if isset($HOOK_FOOTER)}
<!-- Footer -->
<div class="footer-container">
<footer id="footer"  class="container">
<div class="row">{$HOOK_FOOTER}</div>
</footer>
</div><!-- #footer -->
{/if}*}
</div><!-- #page -->
{/if}
{include file="$tpl_dir./global.tpl"}
</body>
</html>