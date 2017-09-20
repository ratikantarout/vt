{*
{if $page_name =='index'}
<!-- Module HomeSlider -->
{if isset($homeslider_slides)}
<div id="homepage-slider">
{if isset($homeslider_slides.0) && isset($homeslider_slides.0.sizes.1)}{capture name='height'}{$homeslider_slides.0.sizes.1}{/capture}{/if}
<ul id="homeslider"{if isset($smarty.capture.height) && $smarty.capture.height} style="max-height:{$smarty.capture.height}px;"{/if}>
{foreach from=$homeslider_slides item=slide}
{if $slide.active}
<li class="homeslider-container">
<a href="{$slide.url|escape:'html':'UTF-8'}" title="{$slide.legend|escape:'html':'UTF-8'}">
<img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`homeslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}"{if isset($slide.size) && $slide.size} {$slide.size}{else} width="100%" height="100%"{/if} alt="{$slide.legend|escape:'htmlall':'UTF-8'}" />
</a>
{if isset($slide.description) && trim($slide.description) != ''}
<div class="homeslider-description">{$slide.description}</div>
{/if}
</li>
{/if}
{/foreach}
</ul>
</div>
{/if}
<!-- /Module HomeSlider -->
{/if}*}


{if $page_name =='index'}
    {if isset($homeslider_slides)}
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                {foreach from=$homeslider_slides key=scnt item=slide}
                    <li data-target="#myCarousel" data-slide-to="{$scnt}" class="{if $scnt==0}active{/if}"></li>
                    {/foreach}
            </ol>
            <div class="carousel-inner text-color-green" role="listbox">
                {foreach from=$homeslider_slides key=scnt item=slide}
                    {if $slide.active}
                        <div class="item {if $scnt==0}active{/if}">
                            <a href="{$slide.url|escape:'html':'UTF-8'}" title="{$slide.legend|escape:'html':'UTF-8'}">
                                <img src="{$link->getMediaLink("`$smarty.const._MODULE_DIR_`homeslider/images/`$slide.image|escape:'htmlall':'UTF-8'`")}" alt="{$slide.legend|escape:'htmlall':'UTF-8'}"  height="448"></a>
                                {if isset($slide.description) && trim($slide.description) != ''}
                                <div class="homeslider-description">{$slide.description}</div>
                            {/if}
                        </div>

                    {/if}
                {/foreach}
            </div>
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left text-color-green" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right text-color-green" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    {/if}
{/if}