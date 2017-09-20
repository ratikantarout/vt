



<div id="search_block_top">
    <form id="searchbox" method="get" action="{$link->getPageLink('search', null, null, null, false, null, true)|escape:'html':'UTF-8'}" class="navbar-form" role="search">
        <div class="input-group">
            <input type="hidden" name="controller" value="search" />
            <input type="hidden" name="orderby" value="position" />
            <input type="hidden" name="orderway" value="desc" />
            <input type="text" id="search_query_top" name="search_query" class="search_query form-control" placeholder="Search" value="{$search_query|escape:'htmlall':'UTF-8'|stripslashes}">
            <div class="input-group-btn">
                <button class="btn btn-default" name="submit_search" type="submit"><i class="glyphicon glyphicon-search button-search"></i></button>
            </div>
        </div>
    </form>
</div>