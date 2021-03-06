<!--{template header}-->
<div style="width:100%; height:15px;color:#000;margin:0px 0px 10px;">
    <div style="float:left;"><a href="index.php?admin_main/stat{$setting['seo_suffix']}" target="main"><b>控制面板首页</b></a>&nbsp;&raquo;&nbsp;财富充值</div>
</div>
<!--{if isset($message)}-->
<!--{eval $type=isset($type)?$type:'correctmsg'; }-->
<div class="alert  alert-warning">{$message}</div>
<!--{/if}-->

<form action="index.php?admin_setting/ebank{$setting['seo_suffix']}" method="post">
    <a name="基本设置"></a>
    <table class="table">
        <tr class="header">
            <td colspan="2">支付宝配置说明</td>
        </tr>
        <tr>
            <td colspan="2">
                1、“支付宝”(http://www.alipay.com)是中国领先的网上支付平台，由全球最佳 B2B 公司阿里巴巴公司创建，为 Ask2问答 用户提供财富充值平台。你只需进行简单的设置，即可使系统内容和人气，真成为除广告收入外的重要利润来源，从而实现网站的规模化经营。<br />
                2、由于涉及现金交易，为避免因操作不当而造成的资金损失，请在开始使用支付宝积分交易功能(不包含支付宝按钮功能)前，务必仔细阅读《用户使用说明书》中有关电子商务的部分，当确认完全理解和接受相关流程及使用方法后再进行相关设置。<br />
                3、你可以设置允许用户通过现金在线支付的方式，为其交易积分账户充值，用于购买发布悬赏问题、兑换礼品等功能。支付宝积分交易功能，需在“积分设置”中启用交易积分，并同时设置相应的积分策略以满足不同场合的需要。请务必正确设置你的收款支付宝账号，否则将造成用户付款后积分无法实时到账，造成大量需要人工处理的订单信息。<br />
                4、除 Ask2问答 官方网站或官方论坛另行通知以外，Ask2问答 提供的支付宝支付服务每笔交易收取 1.5% 的手续费。请及时关注相关业务的最新通知，各项政策或流程的变更、调整，以 Ask2问答 官方网站或官方论坛提供的信息为准。<br />
                5、你使用支付宝服务是建立在完全自愿的基础上，除 Ask2问答 因主观恶意的因素造成的资金损失以外，Ask2问答官方不对因使用此功能造成的任何损失承担责任。<br />
                6、支付宝业务咨询 Email 为 6688@taobao.com；支付宝客户服务电话为 +86-0571-88156688。
            </td>
        </tr>
        <tr class="header">
            <td colspan="2">参数配置</td>
        </tr>
        <tr>
            <td width="45%"><b>开启财富充值：</b><br><span class="smalltxt">关闭后网站将没有财富充值的功能</span></td>
            <td>
                <input class="radio" type="radio" {if 1==$setting['recharge_open'] }checked{/if}  value="1" name="recharge_open" />是&nbsp;&nbsp;
                       <input class="radio" type="radio" {if 0==$setting['recharge_open'] }checked{/if}  value="0" name="recharge_open" />否
            </td>
        </tr>
        <tr>
            <td width="45%"><b>充值汇率:</b><br><span class="smalltxt">以人名币1元为单位，例如 1元=10财富值</span></td>
            <td>1元 = <input type="text" class="txt" name="recharge_rate" value="{$setting['recharge_rate']}" size="8"/> 财富值</td>
        </tr>
        <tr class="header">
            <td colspan="2">支付宝及时到账配置</td>
        </tr>
        <tr>
            <td width="45%"><b>收款支付宝账号：</b><br><span class="smalltxt">您网站的收款支付宝账号，确保正确有效</span></td>
            <td><input type="text" class="txt" name="alipay_seller_email" value="{$setting['alipay_seller_email']}"/></td>
        </tr>
        <tr>
            <td width="45%"><b>合作者身份 (partnerID):</b><br><span class="smalltxt">支付宝签约用户请在此处填写支付宝分配给你的合作者身份，签约用户的手续费按照你与支付宝官方的签约协议为准,请咨询0571-88158090</span></td>
            <td><input type="text" class="txt" name="alipay_partner" value="{$setting['alipay_partner']}"/></td>
        </tr>
        <tr>
            <td width="45%"><b>交易安全校验码 (key):</b><br><span class="smalltxt">支付宝签约用户可以在此处填写支付宝分配给你的交易安全校验码，此校验码你可以到支付宝官方的商家服务功能处查看</span></td>
            <td><input type="password" class="txt" name="alipay_key" value="{$setting['alipay_key']}"/></td>
        </tr>
    </table>
    <br>
    <center><input type="submit" class="btn btn-success" name="submit" value="提 交"></center><br>
</form>
<br>
<!--{template footer}-->