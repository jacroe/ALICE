{{include file="header.tpl" page="xbmc"}}
<div class="container">
<div class="hero-unit">
<h1>{{$masthead}}</h1>
<p>{{$subhead}}</p>
</div>


<div class=row>
<div class=span12>
<div class="page-header">
<h1>TV Shows</h1>
</div>
<ul class="thumbnails">
{{foreach $arrayShows as $show}}
<li class=span3>
  <div class=thumbnail>
  <a href="xbmc.php?show={{$show->tvshowid}}" class=thumbnail><img src="inc/image.php?i=xbmcShow_{{$show->tvshowid}}" alt="{{$show->label}}" /></a>
  </div>
</li>
{{/foreach}}
</ul>
</div>

<div class=span12>
<div class="page-header">
<h1>Films</h1>
</div>
<ul class="thumbnails">
{{foreach $arrayFilms as $film}}
<li class=span3>
  <div class=thumbnail>
  <a href="xbmc.php?movie={{$film->movieid}}" class=thumbnail><img src="inc/image.php?i=xbmcFilm_{{$film->movieid}}" alt="{{$film->label}}"/></a>
  </div>
</li>
{{/foreach}}
</ul>
</div>
</div>
{{include file="footer.tpl" page="xbmc"}}
