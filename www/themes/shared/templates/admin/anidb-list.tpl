<h1>{$page->title}</h1>

{if $anidblist}

<div class="well well-sm">
<div style="float:right;">

	<form name="anidbsearch" action="">
		<label for="animetitle">Title</label>
		<input id="animetitle" type="text" name="animetitle" value="{$animetitle}" size="15" />
		&nbsp;&nbsp;
		<input class="btn btn-default" type="submit" value="Go" />
	</form>
</div>

{$pager}

<br/><br/>

<table style="width:100%;margin-top:10px;" class="Sortable data table table-striped responsive-utilities jambo-table">

	<tr>
		<th style="width:60px;">AniDB Id</th>
		<th>Title</th>
		<th style="width:100px;" class="mid">Options</th>
	</tr>

	{foreach from=$anidblist item=anidb}
	<tr class="{cycle values=",alt"}">
		<td class="less"><a href="http://anidb.net/perl-bin/animedb.pl?show=anime&amp;aid={$anidb.anidbid}" title="View in AniDB">{$anidb.anidbid}</a></td>
		<td><a title="Edit" href="{$smarty.const.WWW_TOP}/anidb-edit.php?id={$anidb.anidbid}">{$anidb.title|escape:"htmlall"}</a></td>
		<td class="mid"><a title="Delete this AniDB entry" href="{$smarty.const.WWW_TOP}/anidb-delete.php?id={$anidb.anidbid}">delete</a> | <a title="Remove this anidbid from all releases" href="{$smarty.const.WWW_TOP}/anidb-remove.php?id={$anidb.anidbid}">remove</a></td>
	</tr>
	{/foreach}

</table>

    <br/>
    {$pager}
{else}
<p>No AniDB episodes available.</p>
{/if}
</div>
