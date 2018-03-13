<div class="top">
    <div class="area">
        <div class="right">
            <ul>
                <li><a href="/">粗耕首页</a></li>
                <li class="pipe">|</li>
                <li><a href="/member">我的粗耕</a></li>
                <li class="pipe">|</li>
                <li>
                    <a href="/cart">
                        <span class="iconfont icon-cartfill"></span>
                        <span>购物车</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="/member/collection"><span class="iconfont icon-favorfill"></span> <span>收藏夹</span></a></li>
                <li class="pipe">|</li>
                <li>
                    <a href="/item/catlog">
                        <span>商品分类</span>
                    </a>
                </li>
                <li class="pipe">|</li>
                <li><a href="/seller">卖家中心</a></li>
                <li class="pipe">|</li>
                <li><a href="http://cg.liaidi.com/index.php?m=page&c=detail&pageid=42">联系客服</a></li>
            </ul>
        </div>
        @if($islogined)
        <span>Hi <a href="/member" style="color: #f40;">{{$username}}</a>, 欢迎回来</span>
        <a href="/account/logout">[退出登录]</a>
        @else
        <span>Hi 欢迎回来</span>
        <a href="/account/login">[登录]</a>
        <a href="/account/register">[免费注册]</a>
        @endif
    </div>
</div>
<div class="header">
    <div class="area banner">
        <div class="global-logo">
            <img src="{{asset('images/cugeng/global-logo.png')}}">
        </div>
        <div class="global-search-box">
            <form method="get" action="/">
                <input type="hidden" name="m" value="item">
                <input type="hidden" name="c" value="search">
                <div class="input-box">
                    <input type="text" class="text" placeholder="商品名称" name="q" value="{{$q or ''}}">
                    <input type="submit" class="btn" value="搜索">
                </div>
            </form>
            <div class="hot">
                热门搜索:
                <a href="/item/search?q=">花菜</a>、
                <a href="/item/search?q=">胡萝卜</a>、
                <a href="/item/search?q=">五花肉</a>
            </div>
        </div>
        <ul class="apps">
            <li>
                <div class="pic showqrcode"><img src="{{asset('images/common/weixin_qrcode.jpg')}}"></div>
                <p>在微信关注我们</p>
            </li>
            <li>
                <div class="pic showqrcode"><img src="{{asset('images/common/app_qrcode.jpg')}}"></div>
                <p>下载粗耕APP</p>
            </li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    $(".showqrcode").mouseenter(function () {
        var src = $(this).find('img').attr('src');
        var offset = $(this).offset();
        var img = $("<img/>").width(200).height(200).attr('id','J-qrcode-preview').attr('src', src).appendTo(document.body);
        img.css({'z-index':9999, 'left':offset.left + $(this).width() - 200, 'top':offset.top+$(this).height(),'position':'fixed', 'border':'1px #DDD solid'});
    }).mouseleave(function () {
        $("#J-qrcode-preview").remove();
    });
</script>
<div class="global-nav">
    <div class="nav">
        <div class="cat"><a href="{U:('m=item&c=catlog')}"><span class="iconfont icon-sort"></span> 全部商品分类</a></div>
        <ul>
            <li><a href="{U:('/')}"{if $_G[nav]=="home"} class="cur"{/if}>首页</a></li>
            <li><a href="{U:('m=item&c=youxuan')}"{if $_G[nav]=="item"} class="cur"{/if}>粗耕优选</a></li>
            <li><a href="{U:('m=shop&c=index')}"{if $_G[nav]=="shop"} class="cur"{/if}>企业店铺</a></li>
            <li><a href="{U:('m=member&c=order&a=index')}">我的订单</a></li>
        </ul>
        <div class="cart" id="nav-cart">
            <a href="{U:('m=cart&c=index')}">
                <span class="ico"></span>
                <span>购物车{cookie cart_total_count}件</span>
                <strong>去结算>></strong>
            </a>
        </div>
    </div>
</div>
