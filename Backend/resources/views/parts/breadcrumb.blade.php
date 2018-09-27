<div class="pageheader">
    <h2><i class="fa {{ $icon }}"></i> {{ $current }} @if(isset($comment)) <span>{{ $comment }}</span> @endif </h2>
    <div class="breadcrumb-wrapper">
        <span class="label">Você esta aqui:</span>
        <ol class="breadcrumb">
            <li><a href="{{ url($url) }}">{{ $parent }}</a></li>
            <li class="active">{{ $current }}</li>
        </ol>
    </div>
</div>