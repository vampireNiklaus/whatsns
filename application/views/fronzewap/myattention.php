<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
          我的关注
            </div>
                          <ul class="ui-list ui-list-one ui-list-link ui-border-tb">
                 {if $attentionlist==null}
                
               
    <p class="user-p-tip ui-txt-warning">  你还没有关注任何人。</p>

                 {/if}
                    <!--{loop $attentionlist $index $follower}-->
    <li class="ui-border-t" onclick="window.location.href='{url user/space/$follower['uid']}'">
    
        <div class="ui-list-thumb">
            <span style="background-image:url({$follower['avatar']})"></span>
        </div>
        <div class="ui-list-info">
            <h4 class="ui-nowrap">{$follower['username']}</h4>
            <div class="ui-txt-info">
             <!--{if (1 == $follower['gender'])}--> 男 
            
             <!--{else}-->
             女
            <!--{/if}-->
            </div>
        </div>
    </li>
  <!--{/loop}-->    
</ul>
          <div class="pages" >{$departstr}</div>   
    </section>
</section>


<!--{template footer}-->