<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
                     <!--精选文章-->
    <div class="au_side_box" atyle="margin-top:.1rem">

        <div class="au_box_title " >

            <div>
                <i class="fa fa-file-text-o lv"></i>精选文章

            </div>

        </div>
        <div class="au_side_box_content">
            <!--列表部分-->
                    <div class="au_resultitems">
                        <!--{loop $topiclist $index $topic}-->   
                        <div class="au_item"  {if $topic['image']!=null} style="height:2.2rem" {/if}>
                          <div class="au_question_title">    <a   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a></div>
                          <div class="au_question_user_info">
                               <a class="" href="{url user/space/$topic['authorid']}">
                    <img class="au_question_user_info_avatar" src="{$topic['avatar']}" >
                </a>  <span>      <a class="blue-link" target="_blank" href="{url user/space/$topic['authorid']}">
                {$topic['author']}
               {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a></span><span><i class="fa fa-clock-o"></i>{$topic['format_time']} </span>
                            
                              <span><i class="fa fa-twitch"></i>{$topic['articles']} </span>
                                <span>  <a title="取消热文推荐" href="{url topic/cancelhot/$topic['id']}">取消推荐</a> </span>
                           
                            
                          </div>
                           <div class="au_question_info_content">
                             
   {if $topic['image']!=null}  
   
          <div class="thumbnail_img">
                                   <a  href="{url topic/getone/$topic['id']}" >
            <img src="{$topic['image']}">
        </a>
                                  </div>
            {/if}
                                  {if $topic['price']!=0}
                         <div class="box_toukan ">
											
										
											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>
											
											
										    
										</div>
                   {else}
                  {eval echo clearhtml($topic['describtion']);}
                  
                    {/if}
                           </div>
                          
                        </div>
                   
    <!--{/loop}-->
                    </div>
            </div>
             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>
  

<!--{template footer}-->