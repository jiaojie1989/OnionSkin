{extends file="_centered.tpl"}
{block name=title}Error 500{/block}
{block name="body"}
<div class="container container-table">
    <div class="row vertical-center-row">
			<div class="col-md-6 col-md-offset-3">
				<h1>Error 500 
				<small>{$L.error_500}</small></h1>
				<blockquote>
  <p>{$L.error_404_appology}</p>
  <footer>{$L.error_404_team}</footer>
</blockquote><br /><br /><br /><br /><a href="/">{$L.error_return_to_main_page}</a>
			</div>
		</div>
	</div>
{/block}