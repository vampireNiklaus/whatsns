<!--{template header}-->
<style>
    body{
        background: #f1f5f8;;
    }
</style>
          
                 <!--最新公告-->
    <div class="au_side_box" atyle="margin-top:.1rem">

        <div class="au_box_title " >

            <div>
                <i class="fa fa-file-text-o lv"></i>最新公告

            </div>

        </div>
        <div class="au_side_box_content">
            <!--列表部分-->
                    <div class="au_resultitems">
                         <!--{loop $notelist $index $note}-->
                        <div class="au_item"  {if $note['image']!=null} style="height:2.2rem" {/if}>
                          <div class="au_question_title">    <a   {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if}  >{$note['title']}</a></div>
                          <div class="au_question_user_info">
                               <a class="" href="{url user/space/$note['authorid']}">
                    <img class="au_question_user_info_avatar" src="{$note['avatar']}" >
                </a>  <span>      <a class="blue-link" target="_blank" href="{url user/space/$note['authorid']}">
                {$note['author']}
               {if $note['author_has_vertify']!=false}<i class="fa fa-vimeo {if $note['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $note['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a></span><span><i class="fa fa-clock-o"></i>{$note['format_time']} </span>
                            
                              <span><i class="fa fa-twitch"></i>{$note['comments']}评论 </span>
                               
                            
                          </div>
                           <div class="au_question_info_content">
                             
   {if $note['image']!=null}  
   
          <div class="thumbnail_img">
                                   <a   {if $note['url']} href="{$note['url']}"  {else}  href="{url note/view/$note['id']}" {/if} >
            <img src="{$note['image']}">
        </a>
                                  </div>
            {/if}
                
                  {eval echo clearhtml($note['content']);}
                  
                  
                           </div>
                          
                        </div>
                   
    <!--{/loop}-->
                    </div>
            </div>
             <div class="pages" style="margin-bottom:15px;">{$departstr}</div>
        </div>
        



<!--{template footer}-->