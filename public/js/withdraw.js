function pxWithdrawConfirm(withdrawId) {
    Admin.Messages.confirm('Подтвердить вывод №' + withdrawId + '?').then((confirmed) => {
        if (confirmed.value) {
            axios.post(Admin.Url.app('/controlpanel/withdraws/confirm'), {
                withdrawId: withdrawId
            }).then((res) => {
                Admin.Messages.message(res.data);
            })
        }
    })
}

function pxWithdrawCancel(withdrawId) {
    Admin.Messages.confirm('Отменить вывод №' + withdrawId + '? Средства будут возвращены на баланс сотрудника.').then((confirmed) => {
        if (confirmed.value) {
            axios.post(Admin.Url.app('/controlpanel/withdraws/cancel'), {
                withdrawId: withdrawId
            }).then((res) => {
                Admin.Messages.message(res.data);
            })
        }
    })
}
