<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            我的文章
            </div>
      
         
      <div id="list-container">
        <!-- 回答列表模块 -->
<ul class="note-list">
   <!--{if $topiclist}-->
   
        <!--{loop $topiclist $index $topic}-->       
                
    <li id="note-{$topic['id']}" data-note-id="{$topic['id']}" {if $topic['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $topic['image']!=null}  
      <a class="wrap-img"  href="{url topic/getone/$topic['id']}"  target="_self">
            <img src="{$topic['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">
            
            
               
                
                   
      
        <a class="avatar" target="_self" href="{url user/space/$topic['authorid']}">
                    <img src="{$topic['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$topic['authorid']}">{$topic['author']}</a>
                
   
        
                
                <span class="time" data-shared-at="{$topic['format_time']}">{$topic['format_time']}</span>
            </div>
            </div>
            <a class="title" target="_self"   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a>
            <p class="abstract">
                {eval echo clearhtml($topic['describtion']);}
                
            </p>
            <div class="meta">

                <a target="_self"  href="{url topic/getone/$topic['id']}" >
                    <i class="fa fa-eye"></i> {$topic['views']}
                </a>        <a target="_self"   href="{url topic/getone/$topic['id']}#comments" >
                <i class="fa fa-comment-o"></i> {$topic['articles']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$topic['likes']}</span>
             <a target="_self"   href=" {url user/editxinzhi/$topic['id']}" >
                <i class="fa fa-edit"></i> 编辑文章
            </a>  
           
            
            </div>
        </div>
    </li>

    <!--{/loop}-->
      <!--{else}-->
      
          <!--{/if}-->
                    
     
   


   
   

   


   
   

</ul>
  <div class="pages" >{$departstr}</div>   
      </div>
    </section>
</section>


<!--{template footer}-->