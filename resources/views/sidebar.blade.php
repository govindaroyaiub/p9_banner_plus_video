<div class="sidebar mx-4 bg-gray-200 rounded-lg md:flex flex-col justify-between">
    <ul class="space-y-2">
        <li class="{{ request()->is('/') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/">Dashboard</a>
        </li>
        <li class="{{ request()->is('banner') || request()->is('project/banner/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/banner">Banners</a>
        </li>
        <li class="{{ request()->is('video') || request()->is('project/video/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/video">Videos</a>
        </li>
        <li class="{{ request()->is('banner_sizes') || request()->is('banner_sizes/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/banner_sizes">Banner Sizes</a>
        </li>
        <li class="{{ request()->is('sizes') || request()->is('sizes/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/sizes">Video Sizes</a>
        </li>
        @if(url('/') == 'http://localhost:8000')
        <li class="{{ request()->is('logo') || request()->is('logo/*') ? 'bg-primary text-white rounded-lg' : '' }}"><a
                class="rounded-lg hover:bg-primary hover:text-white px-3 py-2 block" href="/logo">Logos/Companies</a>
        </li>
        @endif
    </ul>
    <div class="text-center text-sm text-gray-700 mb-2">&copy; Planetnine - <?= Date('Y') ?></div>
</div>