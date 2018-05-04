<!--{template header}-->
<!--{eval $adlist = $this->fromcache("adlist");}-->
<div class="container index">
    <div class="row">
    <div class="col-xs-17 main">
     <div class="recommend-collection">



                <!--{loop $sublist  $category1}-->


                   <a class="collection" target="_self" href="{url topic/catlist/$category1['id']}">
            <img src="$category1['image']" alt="195" style="height:32px;width:32px;">
            <div class="name">{$category1['name']}</div>
        </a>
                <!--{/loop}-->


              </div>

    <div class="recommend-collection">
             最新文章
          </div>
    <div class="split-line"></div>
    <div id="list-container">
     <!--{if $topiclist==null}-->
     <div class="text"><span>目前还没有发布过文章</span> </div>
        <!--{/if}-->
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
                <a class="blue-link" target="_blank" href="{url user/space/$topic['authorid']}">
                {$topic['author']}
                 {if $topic['author_has_vertify']!=false}<i class="fa fa-vimeo {if $topic['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $topic['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
                </a>




                <span class="time" data-shared-at="{$topic['format_time']}">{$topic['format_time']}</span>
            </div>
            </div>
            <a class="title" target="_blank"   href="{url topic/getone/$topic['id']}"  >{$topic['title']}</a>
            <p class="abstract">
                {if $topic['price']!=0}
                         <div class="box_toukan ">


											<a  class="thiefbox font-12" ><i class="icon icon-lock font-12"></i> &nbsp;阅读需支付&nbsp;$topic['price']&nbsp;&nbsp;积分……</a>



										</div>
                   {else}
                     {eval echo clearhtml($topic['describtion']);}
                    {/if}


            </p>
            <div class="meta">

                <a target="_blank"  href="{url topic/getone/$topic['id']}" >
                    <i class="fa fa-eye"></i> {$topic['views']}
                </a>        <a target="_blank"   href="{url topic/getone/$topic['id']}#comments" >
                <i class="fa fa-comment-o"></i> {$topic['articles']}
            </a>      <span><i class=" fa fa-heart-o"></i>  {$topic['likes']}</span>
            </div>
        </div>
    </li>

    <!--{/loop}-->

    </ul>
    <!-- 文章列表模块 -->
       <div class="pages">
    $departstr
    </div>
    </div>
    </div>

    <!--右边栏目-->
    <div class="col-xs-7  aside ">

   <!--{template sider_author}-->

                  <!--{template sider_hotarticle}-->
    </div>





        </div>


    </div>
<!--{template footer}-->