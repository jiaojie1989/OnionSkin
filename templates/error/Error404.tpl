{extends file="_centered.tpl"}
{block name=title}Error 404{/block}
{block name="body"}
<div class="container container-table">
<div class="card  mb-3 mt-3">
  <div class="card-block">
    <div class="row vertical-center-row">
			<div class="col-md-6 col-md-offset-3">
				<h1>Error 404 
				<small>{$L.error_404}</small></h1>
				<blockquote class="blockquote">
  <p class="mb-0">{$L.error_404_appology}</p>
  <footer class="blockquote-footer">{$L.error_404_team}</footer>
</blockquote><br /><br /><br /><br /><a href="/">{$L.error_return_to_main_page}</a>
			</div>
		</div>
	</div>
		</div>
	</div>
{/block}