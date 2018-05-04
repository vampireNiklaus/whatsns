<!--{template header}-->
<style>
.zthead {
    position: relative;
    min-height: 60px;
    padding: 10px 10px 0px 70px;
    border-bottom: 1px solid #e6e6e6;
    background-color: #fff;
}
.zthead .img, .zthead .img {
    position: absolute;
    left: 10px;
    top: 10px;
}
.img img {
    border-radius: 4px;
}
.zthead .title
{
    display: table;
    content: " ";
	margin:0px;

}
.zthead h1, .zthead h1 {
    margin: 3px 0 5px 0;
    font-size: 17px;
    color: #333;
}
.zthead p, .zthead p {
    margin: 0;
  font-size:12px;
}
.c-hui {
    color: #999999;
}
.fl {
    float: left!important;
}
</style>
<div class="zthead ui-clear">
			<a class="img"><img width="50" src="$catmodel['bigimage']" alt="{$catmodel['name']}"></a>
			<div class="title ui-clear">
				<h1 class="fl"> {$catmodel['name']}</h1>
							</div>
							 <p class="c-hui"> 
			        收录了{$rownum}篇文章 ·{$catmodel['questions']}个问题 · {$catmodel['followers']}人关注
		</p>
		</div>
<section class="sec-result">
 <div class="ui-tab" id="tab1">
    <ul class="ui-tab-nav ui-border-b" style="font-size:13px;">
         <li class="current">
        <a href="{url topic/catlist/$cid}">全部文章</a>
        </li>
       
        
           <li>
       <a href="{url category/view/$catmodel['id']}">相关讨论</a>
        </li>
      
    </ul>
  <div id="list-container">
        <!-- 文章列表模块 -->
<ul class="note-list" >
     
               <!--{loop $topiclist $index $topic}-->  
                
    <li id="note-{$topic['id']}" data-note-id="{$topic['id']}" {if $topic['image']!=null}  class="have-img" {else}class="" {/if}>
    {if $topic['image']!=null}  
      <a class="wrap-img"  href="{url topic/getone/$topic['id']}"  target="_blank">
            <img src="{$topic['image']}">
        </a>
            {/if}
        <div class="content">
            <div class="author">
            
            
               
                
                   
      
        <a class="avatar" target="_blank" href="{url user/space/$topic['authorid']}">
                    <img src="{$topic['avatar']}" alt="96">
                </a>      <div class="name">
                <a class="blue-link" target="_blank" href="{url user/space/$topic['authorid']}">{$topic['author']}
                 {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a>
                
  
        
                
                <span class="time" data-shared-at="{$topic['viewtime']}">{$topic['viewtime']}</span>
            </div>
            </div>
            <a class="title" target="_blank"   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a>
           
            <div class="meta">
               
                <a target="_blank"  href="{url topic/getone/$topic['id']}" >
                    <i class="fa fa-eye"></i> {$topic['views']}
                </a>        <a target="_blank" href="{url topic/getone/$topic['id']}#comments" >
                <i class="fa fa-comment-o"></i> {$topic['articles']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$topic['attentions']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->
 

</ul>

      </div>
</div>
   <div class="pages">{$departstr}</div>
</section>






<!--{template footer }-->