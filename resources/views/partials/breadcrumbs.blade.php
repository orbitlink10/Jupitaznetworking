@if(!empty($breadcrumbs))
<nav aria-label="Breadcrumb" class="container mt-3">
    <ol class="breadcrumb" itemscope itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="{{ route('home') }}"><span itemprop="name">Home</span></a>
            <meta itemprop="position" content="1">
        </li>
        @foreach($breadcrumbs as $crumb)
            <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                @if(!$loop->last && isset($crumb['url']))
                    <a itemprop="item" href="{{ $crumb['url'] }}"><span itemprop="name">{{ $crumb['name'] }}</span></a>
                @else
                    <span itemprop="name">{{ $crumb['name'] }}</span>
                @endif
                <meta itemprop="position" content="{{ $loop->index + 2 }}">
            </li>
        @endforeach
    </ol>
</nav>
@endif
