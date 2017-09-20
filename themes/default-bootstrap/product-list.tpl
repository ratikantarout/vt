<style type="text/css">
    a{
        color: #272b65;
    }
</style>

{if isset($products) && $products}
    {*define number of products per line in other page for desktop*}
    {if $page_name !='index' && $page_name !='product'}
        {assign var='nbItemsPerLine' value=3}
        {assign var='nbItemsPerLineTablet' value=2}
        {assign var='nbItemsPerLineMobile' value=3}
    {else}
        {assign var='nbItemsPerLine' value=4}
        {assign var='nbItemsPerLineTablet' value=3}
        {assign var='nbItemsPerLineMobile' value=2}
    {/if}
    {*define numbers of product per line in other page for tablet*}
    {assign var='nbLi' value=$products|@count}
    {math equation="nbLi/nbItemsPerLine" nbLi=$nbLi nbItemsPerLine=$nbItemsPerLine assign=nbLines}
    {math equation="nbLi/nbItemsPerLineTablet" nbLi=$nbLi nbItemsPerLineTablet=$nbItemsPerLineTablet assign=nbLinesTablet}
    <!-- Products list -->
    <ul{if isset($id) && $id} id="{$id}"{/if} class="product_list grid row{if isset($class) && $class} {$class}{/if}">
        {foreach from=$products item=product name=products}
            {math equation="(total%perLine)" total=$smarty.foreach.products.total perLine=$nbItemsPerLine assign=totModulo}
            {math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineTablet assign=totModuloTablet}
            {math equation="(total%perLineT)" total=$smarty.foreach.products.total perLineT=$nbItemsPerLineMobile assign=totModuloMobile}
        {if $totModulo == 0}{assign var='totModulo' value=$nbItemsPerLine}{/if}
    {if $totModuloTablet == 0}{assign var='totModuloTablet' value=$nbItemsPerLineTablet}{/if}
{if $totModuloMobile == 0}{assign var='totModuloMobile' value=$nbItemsPerLineMobile}{/if}



<li class="ajax_block_product{if $page_name == 'index' || $page_name == 'product'} col-xs-12 col-sm-4 col-md-3{else} col-xs-12 col-sm-6 col-md-4{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLine == 0} last-in-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLine == 1} first-in-line{/if}{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModulo)} last-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 0} last-item-of-tablet-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLineTablet == 1} first-item-of-tablet-line{/if}{if $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 0} last-item-of-mobile-line{elseif $smarty.foreach.products.iteration%$nbItemsPerLineMobile == 1} first-item-of-mobile-line{/if}{if $smarty.foreach.products.iteration > ($smarty.foreach.products.total - $totModuloMobile)} last-mobile-line{/if} list-unstyled ">
    <div class="box-home">
        <div class="left-block">
            <div class="main bg-info">
                <a class="product_img_link" href="{$product.link|escape:'html':'UTF-8'}" title="{$product.name|escape:'html':'UTF-8'}{l s=" - VisitorTrip"}" itemprop="url">
                    <img class="absolute img-responsive img-thumbnail" data-echo="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home_default')|escape:'html':'UTF-8'}" src="https://d3w0fztyp9j74f.cloudfront.net/img/ploading.gif" alt="" />
                </a>
            </div>
        </div>
        <div class="right-block">
            <h5 itemprop="name" class="text-center"> 
                <a style="margin:calc();" itemprop="url" title="{$product.name|escape:'html':'UTF-8'}{l s=" - VisitorTrip"}" href="{$product.link|escape:'html':'UTF-8'}" class="text-capitalize">{$product.name|truncate:45:'...'|escape:'html':'UTF-8'}</a>
                {if $product.reference==$product.ean13 }
                    <p class="text-color-green loc_home">{$product.reference|truncate:22:'...'|trim:' '|escape:'html':'UTF-8'}</p>
                {else}
                    <p class="text-color-green loc_home">{if $product.reference}{$product.reference|truncate:22:'...'|trim:' '|escape:'html':'UTF-8'},{/if}{$product.ean13|truncate:22:'...'|escape:'html':'UTF-8'}</p>
                {/if}
            </h5>
        </div>
    </div>
</li>

{/foreach}
</ul>
{addJsDefL name=min_item}{l s='Please select at least one product' js=1}{/addJsDefL}
{addJsDefL name=max_item}{l s='You cannot add more than %d product(s) to the product comparison' sprintf=$comparator_max_item js=1}{/addJsDefL}
{addJsDef comparator_max_item=$comparator_max_item}
{addJsDef comparedProductsIds=$compared_products}
{/if}
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
