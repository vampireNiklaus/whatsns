
<!--{template header}-->

<section class="ui-container">
<!--{template space_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            Ta的回答
            </div>
           <ul class="note-list" style="padding:10px;">
   <!--{if $answerlist}-->
   
      <!--{loop $answerlist $question}-->
                
    <li id="note-{$question['id']}" data-note-id="{$question['id']}" {if $question['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $question['image']!=null}  
      <a class="wrap-img"  href="{url question/view/$question['qid']}"  target="_self">
            <img src="{$question['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">
            
            
               
                
                   
        {if $question['hidden']==1}
  
          <a class="avatar"  href="javascript:void(0)">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link"  href="javascript:void(0)">匿名用户</a>
                
                
        {else}
        <a class="avatar" target="_self" href="{url user/space/$question['authorid']}">
                    <img src="{$question['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_self" href="{url user/space/$question['authorid']}">{$question['author']}</a>
                
        {/if}
        
                
                <span class="time" data-shared-at="{$question['format_time']}">{$question['time']}</span>
            </div>
            </div>
            <a class="title" target="_self"   href="{url question/view/$question['qid']}"  >{$question['title']}</a>
            <p class="abstract">
                {eval echo strip_tags($question['description']);}
                
            </p>
            <div class="meta">

                    <a target="_self"   href="{url question/view/$question['qid']}#comments" >
                <i class="fa fa-comment-o"></i> {$question['comments']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$question['supports']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->
      <!--{else}-->
       
            <div class="text">
            真不巧，作者还没回答任何问题~
          </div>
          <!--{/if}-->
                    
     
   


   
   

   


   
   

</ul>
  <div class="pages" >{$departstr}</div>    
    </section>
</section>


<!--{template footer}-->