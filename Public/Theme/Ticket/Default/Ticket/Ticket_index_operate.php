<div class="admin-task-bd ticket-operation-bd">
    <a class="am-link-muted print-ticket am-margin-right-xs" href="<?= $label->url('View-printer', array ('number' => $value["ticket_number"])); ?>"><span class="am-icon-print"></span></a>

    <span>耗时: <?= empty($value['ticket_run_time']) ? '未处理' : $label->timing($value['ticket_run_time']); ?></span>
    <i class="am-margin-left-xs am-margin-right-xs">|</i>
    <span>责任人: <?= $value['user_id'] > 0 ? $value['user_name'] : '<span class="am-text-danger">暂无</span>'; ?></span>
    <i class="am-margin-left-xs am-margin-right-xs">|</i>
    <span>工单评价:
        <?= $value['ticket_admin_flag'] == '1' ? '工程师业务不熟悉（没找到功能，不会使用，咨询类问题）' : ''; ?>
        <?= $value['ticket_admin_flag'] == '2' ? '产品设计不合理' : ''; ?>
        <?= $value['ticket_admin_flag'] == '21' ? '产品需求（功能没有）' : ''; ?>
        <?= $value['ticket_admin_flag'] == '3' ? '售后能力差' : ''; ?>
        <?= $value['ticket_admin_flag'] == '4' ? '产品bug' : ''; ?>
        <?= $value['ticket_admin_flag'] == '41' ? '产品bug-老bug' : ''; ?>
        <?= $value['ticket_admin_flag'] == '42' ? '产品bug-正在修复' : ''; ?>
        <?= $value['ticket_admin_flag'] == '43' ? '产品bug-无法复现' : ''; ?>
        <?= $value['ticket_admin_flag'] == '44' ? '产品bug-暂时无法处理（能重现暂时不处理）' : ''; ?>
        <?= $value['ticket_admin_flag'] == '5' ? '无脑工单' : ''; ?>
        <?= $value['ticket_admin_flag'] == '6' ? '客户操作失误' : ''; ?>
        <?= $value['ticket_admin_flag'] == '7' ? '无效工单' : ''; ?>
        <?= $value['ticket_admin_flag'] == '-1' ? '未知' : ''; ?>
    </span>
    <i class="am-margin-left-xs am-margin-right-xs">|</i>

    <?php if($label->checkAuth('TicketPUTTicketsetListTop') === true && ACTION != 'myTicket' ): ?>
        <a href="<?= $label->url('Ticket-Ticket-setListTop', ['number' => $value['ticket_number'], 'method' => 'PUT', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-primary ajax-click"><?= $value['ticket_top_list'] == 1 ? '<i class="am-icon-long-arrow-down"></i> 还原' : '<i class="am-icon-long-arrow-up"></i> 列表置顶' ?></a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
    <?php endif; ?>

    <?php if($value['user_id'] == self::session()->get('ticket')['user_id'] && ACTION == 'myTicket' ) : ?>
        <a href="<?= $label->url('Ticket-Ticket-setTop', ['number' => $value['ticket_number'], 'method' => 'PUT', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-primary ajax-click"><?= $value['ticket_top'] == 1 ? '<i class="am-icon-level-down"></i> 还原' : '<i class="am-icon-level-up"></i> 置顶' ?></a>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
    <?php endif; ?>

    <a href="<?= $label->url('Ticket-Ticket-handle', ['number' => $value['ticket_number'], 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-primary"><i class="am-icon-gg"></i> 处理</a>

    <?php if ($value['ticket_close'] == '0' && $value['ticket_status'] < 3 && $label->checkAuth('TicketPOSTTicketclose') === true ): ?>

        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a href="<?= $label->url('Ticket-Ticket-close', ['number' => $value['ticket_number'], 'method' => 'POST', 'back_url' => base64_encode($_SERVER['REQUEST_URI'])]); ?>" class="am-text-danger ajax-click ajax-dialog" msg="确定要关闭本工单吗？"><i class="am-icon-unlock-alt"></i> 关闭工单</a>
    <?php endif; ?>

    <?php if ($label->checkAuth(GROUP . 'DELETETicketaction') === true): ?>
        <i class="am-margin-left-xs am-margin-right-xs">|</i>
        <a class="am-text-danger ajax-click ajax-dialog" msg="确定删除吗？将无法恢复的！" href="<?= $label->url(GROUP . '-' . MODULE . '-action', array ('id' => $value["ticket_id"], 'method' => 'DELETE', 'back_url' => base64_encode($_SERVER['REQUEST_URI']))); ?>"><span class="am-icon-trash-o"></span></a>
    <?php endif; ?>
</div>