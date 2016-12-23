{extends file="_centered.tpl"}
{block name=title}My Page Title{/block}
{block name="innerbody"}
<h2>{$L.newsnippet}</h2>

<div class="container">
  <form>
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label">{$L.name}*</label>
      <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail3" placeholder="{$L.name}">
		<small class="form-text text-muted">*{$L.requiredfield}</small>
      </div>
    </div>
    <div class="form-group row">
      <label for="inputEmail3" class="col-sm-2 col-form-label">{$L.content}</label>
      <div class="col-sm-10">
		<textarea class="form-control auto_grow" id="exampleTextarea" rows="3"></textarea>
		<small class="form-text text-muted">*{$L.requiredfield}</small>
      </div>
    </div>
	<div class="form-group row">
		<label for="exampleSelect1" class="col-sm-2">{$L.syntaxHighlight}</label>
		<div class="col-sm-10">
		<select class="form-control" id="exampleSelect1">
			<option value="txt">{$L.syntax_none}</option>
			{foreach from=$syntax_list key=syntax_key item=syntax_item}
			<option value="{$syntax_key}">{$syntax_item}</option>
			{/foreach}
		</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="exampleSelect1" class="col-sm-2">{$L.folder}</label>
		<div class="col-sm-10">
		<select class="form-control" id="exampleSelect1">
			<option>{$L.visibility_public}</option>
			<option>{$L.visibility_link}</option>
			<option>{$L.visibility_private}</option>
		</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="exampleSelect1" class="col-sm-2">{$L.visibility}</label>
		<div class="col-sm-10">
		<select class="form-control" id="exampleSelect1">
			<option>{$L.visibility_public}</option>
			<option>{$L.visibility_link}</option>
			<option>{$L.visibility_private}</option>
		</select>
		</div>
	</div>
	<div class="form-group row">
		<label for="exampleSelect1" class="col-sm-2">{$L.expiration}</label>
		<div class="col-sm-10">
		<select class="form-control" id="exampleSelect1">
			<option>{$L.expiration_never}</option>
			<option>10 {$L.time_m_p}</option>
			<option>1 {$L.time_h_s}</option>
			<option>1 {$L.time_d_s}</option>
			<option>1 {$L.time_w_s}</option>
		</select>
		</div>
	</div>
    <div class="form-group row">
      <div class="offset-sm-2 col-sm-10">
        <button type="submit" class="btn btn-primary">{$L.save}</button>
      </div>
    </div>
  </form>
</div>

{/block}
{block name="js_end" append}
<script src="js_c/editor.js"></script>
{/block}