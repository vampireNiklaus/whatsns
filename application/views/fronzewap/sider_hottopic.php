          <!--{eval $categorylist=$this->fromcache('categorylist');}-->
                  <!--{if $categorylist }-->
   <!--热门主题-->
                    <div class="au_side_box">

                        <div class="au_box_title">

                            <div>
                                <i class="fa fa-windows huang"></i>热门话题
                                <a href="{url category/viewtopic/hot}" class="more">more+</a>
                            </div>

                        </div>
                        <div class="au_side_box_content">
                            <ul>
                               <!--{loop $categorylist  $category1}-->
                                <li {if $category1['miaosu']} data-toggle="tooltip" data-placement="bottom" title="" data-original-title=" {eval echo clearhtml($category1['miaosu']);}" {/if}>
                                    <div class="_smallimage">
                                      <a href="{url category/view/$category1['id']}">  <img src="{$category1['bigimage']}"></a>
                                    </div>
                                    <div class="_content">
                                      <div class="_rihgtc">
                                          <span class="subname">
                                           <a href="{url category/view/$category1['id']}">{$category1['name']}</a>  
                                          </span>
                                          <span class="_yuedu">{$category1['followers']}人关注</span>
                                          <p class="_desc" >
                                                 {eval echo clearhtml($category1['miaosu']);}
                                         
                                           </p>
                                      </div>

                                    </div>
                                </li>
                                  <!--{/loop}--> 
                            </ul>
                        </div>
                    </div>
                        <!--{/if}-->