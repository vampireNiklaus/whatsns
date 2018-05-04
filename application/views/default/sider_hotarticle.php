 <div class="recommend"  >
   <div class="title">
     <i class="fa fa-wenzhang"></i>
   <span  class="title_text">推荐文章</span>
   <span class="morelink">
     <a href="{url topic/hotlist}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
   <ul class="list">


  <!--{eval $topiclist=$this->fromcache('hottopiclist');}-->

        <!--{loop $topiclist $nindex $topic}-->
                       <li class="ws_art_text" ><a  class="li-a-title" target="_self" href="{url topic/getone/$topic['id']}" title="{$topic['title']}">{$topic['title']}</a></li>
                       <!--{/loop}-->


      </ul>



    </div>