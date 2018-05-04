
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            我关注的话题
            </div>
                 <!-- 关注话题列表模块 -->
            <!--{if $categorylist==null}-->
          
                <section class="ui-notice" style="z-index:-1;">
    <i></i>
    <p>这里空空如也，赶快去关注你喜欢的话题吧!</p>
    <div class="ui-notice-btn">
        <button class="ui-btn-primary ui-btn-lg" onclick="window.location.href='{url category/viewtopic/hot}'">去关注话题</button>
    </div>
</section>
                 <!--{/if}-->
<ul class="note-list" style="padding:10px;">
      <!--{loop $categorylist $index $cat}-->
                
    <li id="note-{$cat['id']}" data-note-id="{$cat['id']}" >

        <div class="content">
            <div class="author">
            
            
               
                
   
        <a class="avatar" target="_blank" href="{url user/space/$cat['uid']}">
                    <img src="{$cat['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$cat['uid']}">我关注了话题</a>
                
     
                
                <span class="time" data-shared-at="{$cat['doing_time']}">{$cat['doing_time']}</span>
            </div>
            </div>
          
            
           
            <div class="follow-detail">
      <div class="info">
        <a class="avatar-collection" href="{$cat['url']}">
          <img src="{$cat['bigimage']}" alt="180">
</a>       
{if $cat['follow']}
 <a class="btn btn-default following" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])"><i class="fa fa-check"></i><span>已关注</span></a>
    
{else}
 <a class="btn btn-success follow" id="attenttouser_{$cat['id']}" onclick="attentto_cat($cat['id'])"><i class="fa fa-plus"></i><span>关注</span></a>
    
{/if}  
        <a class="title" href="{$cat['url']}">{$cat['name']}</a>
        <p>
          
          {$cat['questions']} 个问题， {$cat['followers']} 人关注
        </p>
      </div>
        <div class="signature">
        {$cat['miaosu']}
        </div>
    </div>
           
 
        
        
           
        </div>
    </li>

    <!--{/loop}-->

</ul>
          <div class="pages" >{$departstr}</div>   
    </section>
</section>


<!--{template footer}-->