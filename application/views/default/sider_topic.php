  <div class="recommend" ><div class="title">
   <i class="fa fa-huati"></i>
 <span class="title_text">推荐话题</span>
    <span class="morelink">
     <a href="{url category/viewtopic/hot}"><i class="fa fa-ellipsis-h" ></i></a>
    </span>
   </div>
        <ul class="list">

        <!--{eval $categorylist=$this->fromcache('categorylist');}-->
                <!--{loop $categorylist $index $category1}-->
                {if $index<8 }
        <li>
        <a href="{url category/view/$category1['id']}" target="_self" class="avatar">
        <img src="$category1['bigimage']" alt="{$category1['name']}" class="topicavatar" >
        </a>



        <a href="{url category/view/$category1['id']}" target="_self" class="name">
           {$category1['name']} <span class="followernum">{$category1['followers']}人关注</span>
        </a>
         <p class="desclipe">
            {eval echo clearhtml($category1['miaosu']);}
        </p></li>
        {/if}
         <!--{/loop}-->
        </ul>
    </div>

