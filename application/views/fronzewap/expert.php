<!--{template header}-->
    <style>
        body{
            background: #f1f5f8;
        }
    </style>
      <!--专家列表-->
                        <div class="au_expert_listitems">
                          <!--{loop $expertlist $expert}-->
                            <div class="ui-row-flex au_expert_listitems_tiem">
                                <div class="ui-col ">
                                    <div class="au_expert_listitems_tiem_avatar">
                                       <a href="{url user/space/$expert['uid']}">
      <img src="{$expert['avatar']}" >
</a> 
                                    </div>
                                 </div>
                                <div class="ui-col ui-col-3">
                                    <div class="au_expert_listitems_tiem_username">
                                           <a  href="{url user/space/$expert['uid']}">
      {$expert['username']}
        {if $expert['author_has_vertify']!=false}<i class="fa fa-vimeo {if $expert['author_has_vertify'][0]=='0'}v_person {else}v_company {/if}  " data-toggle="tooltip" data-placement="right" title="" {if $expert['author_has_vertify'][0]=='0'}data-original-title="个人认证" {else}data-original-title="企业认证" {/if} ></i>{/if}
      </a>
                                    </div>
                                    <!--关注和提问-->
                                    <div class="au_expert_listitems_tiem_guanzhuandtiwen">

                                        <div class="au_expert_listitems_tiem_btnzixun" data-placement="bottom" data-toggle="tooltip" data-original-title="付费{$expert['mypay']}元咨询"  {if $user['uid']==0} onclick="javascript:login()" {else} onclick="window.location.href='{url question/add/$expert[uid]}'" {/if}>
                                            <i class="fa fa-commenting"></i>付费咨询<span>(￥{$expert['mypay']})</span>
                                        </div>
                                        {if $expert['hasfollower']==1}
                                         <div  id="attenttouser_{$expert['uid']}" onclick="attentto_user($expert['uid'])" class="au_expert_listitems_tiem_btnguanzhu  button_followed following">
                                                                                      <i class="fa fa-check"></i> 已关注
                                        </div>
                                        {else}
                                        <div  id="attenttouser_{$expert['uid']}" onclick="attentto_user($expert['uid'])" class="au_expert_listitems_tiem_btnguanzhu button_attention follow">
                                            +关注
                                        </div>
                                        {/if}
                                        
                                    </div>

                                    <!--擅长领域-->
                                    <div class="au_expert_listitems_tiem_cat">
                                             <p>
                                                 <span>
                                                     擅长领域：
                                                 </span>
                                                   <!--{loop $expert['category'] $category}-->
           {if $category['categoryname']!=''}
                  
                         <span class="c_hui">
                                                     <a href="{url category/view/$category['cid']}">{$category['categoryname']}</a>
                                                 </span>
                        {/if}
                        <!--{/loop}-->
                        
                                                 
                                               
                                             </p>
                                    </div>
                                    <!--简介-->
                                    <div class="au_expert_listitems_tiem_jianjie c_hui">
                                           <div class="au_expert_listitems_tiem_jianjie_name">
                                               简介：
                                           </div>
                                        <div class="au_expert_listitems_tiem_jianjie_name">
                                           {$expert['signature']}
                                        </div>
                                    </div>
                                </div>
                             </div>

                           <!--{/loop}-->


                        </div>
                  <div class="pages">{$departstr}</div>   
                  

 

<!--{template footer}-->