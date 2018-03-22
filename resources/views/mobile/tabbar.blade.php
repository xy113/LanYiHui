<nav class="tabbar">
    <div class="bar">
        @if($tab === 'home')
                <div class="item" data-link="{{url('/mobile')}}">
                    <div class="item-icon item-home-active"></div>
                    <div class="item-title item-title-active">首页</div>
                </div>
        @else
                <div class="item" data-link="{{url('/mobile')}}">
                    <div class="item-icon item-home"></div>
                    <div class="item-title">首页</div>
                </div>
        @endif
        @if ($tab === 'grow')
                <div class="item">
                    <div class="item-icon item-grow-active"></div>
                    <div class="item-title item-title-active">成长</div>
                </div>
        @else
                <div class="item">
                    <div class="item-icon item-grow"></div>
                    <div class="item-title">成长</div>
                </div>
        @endif
        @if ($tab === 'com')
                <div class="item">
                    <div class="item-icon item-com-active"></div>
                    <div class="item-title item-title-active">交流</div>
                </div>
        @else
                <div class="item">
                    <div class="item-icon item-com"></div>
                    <div class="item-title">交流</div>
                </div>
        @endif

        @if($tab === 'mine')
                <div class="item" data-link="{{url('/mobile/member')}}">
                    <div class="item-icon item-mine-active"></div>
                    <div class="item-title item-title-active">我的</div>
                </div>
        @else
                <div class="item" data-link="{{url('/mobile/member')}}">
                    <div class="item-icon item-mine"></div>
                    <div class="item-title">我的</div>
                </div>
        @endif
    </div>
</nav>
