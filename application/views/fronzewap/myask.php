
<!--{template header}-->

<section class="ui-container">
<!--{template user_title}-->

   
    <section class="user-content-list">
            <div class="titlemiaosu">
            我的提问
            </div>
                <ul class="ui-list ui-list-text ui-border-tb">
                         <!--{loop $questionlist $index $question}-->
            <li class="ui-border-t">
                <div class="ui-list-info">
                    <h4 class="ui-nowrap">
                  <a href="{url question/view/$question['id']}">{$question['title']}</a>
                    </h4>
                </div>
                <div class="ui-arrowlink "></div>
            </li>
             <!--{/loop}-->         


        </ul>
          <div class="pages" >{$departstr}</div>   
    </section>
</section>


<!--{template footer}-->