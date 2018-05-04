
       <div class="recommend">
   <div class="title">
      <i class="fa fa-wenzhang"></i>
   <span class="title_text">站内公告</span>
      <span class="morelink">
     <a href="{url note/list}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
   <ul class="list">


    <!--{eval $notelist=$this->fromcache('notelist');}-->
                <!--{loop $notelist $nindex $rightnote}-->
                       <li class="ws_art_text" ><a  class="li-a-title" target="_self" title="{$rightnote['title']}" {if $rightnote['url']}href="{$rightnote['url']}"{else}href="{url note/view/$rightnote['id']}"{/if}>{$rightnote['title']}</a></li>
                       <!--{/loop}-->


      </ul>



    </div>