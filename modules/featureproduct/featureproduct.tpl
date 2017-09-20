{foreach from=$ps item=p name=ps}
<div class="code"><h4 class="title-1 h44"> <span>{$p['feature_name']}</span></h4></div>
    <ul class="product_list grid row">
        {foreach from=$p['data'] item=pi name=p}
            <li class="ajax_block_product col-xs-12 col-sm-4 col-md-3  list-unstyled ">
                <div class="box-home">
                    <div class="left-block">
                        <div class="main bg-info">
                            <a class="product_img_link" href="{$pi.link|escape:'html':'UTF-8'}" title="{$pi.name|escape:'html':'UTF-8'}" itemprop="url">
                                <img class="absolute img-responsive img-thumbnail" data-echo="{$link->getImageLink($pi.link_rewrite, $pi.id_image, 'home_default')|escape:'html':'UTF-8'}" src="https://d3w0fztyp9j74f.cloudfront.net/img/ploading.gif" alt="" />
                            </a>
                        </div>
                    </div>
                    <div class="right-block">
                        <h5 itemprop="name" class="text-center"> 
                            <a style="margin:calc();" itemprop="url" title="{$pi.name|escape:'html':'UTF-8'}{l s=" - VisitorTrip"}" href="{$pi.link|escape:'html':'UTF-8'}" class="text-capitalize">{$pi.name|truncate:45:'...'|escape:'html':'UTF-8'}</a>
                            <p class="text-color-green loc_home">{$pi.reference|truncate:22:'...'|trim:' '|escape:'html':'UTF-8'},{$pi.ean13|truncate:22:'...'|escape:'html':'UTF-8'}</p>
                        </h5>
                    </div>
                </div>
            </li>
        {/foreach}
    </ul>
{/foreach}

<script type="text/javascript">
    window.echo = (function (window, document) {
        'use strict';
        var Echo = function (elem) {
            this.elem = elem;
            this.render();
            this.listen();
        };
        var echoStore = [];
        var scrolledIntoView = function (element) {
            var coords = element.getBoundingClientRect();
            return ((coords.top >= 0 && coords.left >= 0 && coords.top) <= (window.innerHeight || document.documentElement.clientHeight));
        };
        var echoSrc = function (img, callback) {
            img.src = img.getAttribute('data-echo');
            if (callback) {
                callback();
            }
        };
        var removeEcho = function (element, index) {
            if (echoStore.indexOf(element) !== -1) {
                echoStore.splice(index, 1);
            }
        };
        var echoImages = function () {
            for (var i = 0; i < echoStore.length; i++) {
                var self = echoStore[i];
                if (scrolledIntoView(self)) {
                    echoSrc(self, removeEcho(self, i));
                }
            }
        };
        Echo.prototype = {
            init: function () {
                echoStore.push(this.elem);
            },
            render: function () {
                if (document.addEventListener) {
                    document.addEventListener('DOMContentLoaded', echoImages, false);
                } else {
                    window.onload = echoImages;
                }
            },
            listen: function () {
                window.onscroll = echoImages;
            }
        };
        var lazyImgs = document.querySelectorAll('img[data-echo]');
        for (var i = 0; i < lazyImgs.length; i++) {
            new Echo(lazyImgs[i]).init();
        }
    })(window, document);
</script>