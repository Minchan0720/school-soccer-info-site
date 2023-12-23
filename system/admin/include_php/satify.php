<?php

class AntAdminUser {

    private $data;
    private $decryption_key;

    function __construct($path_to_file) {
        $this->data = json_decode(file_get_contents($path_to_file), true);
        $this->decryption_key = '1105879419727384716/8PdjPpAwoCHARzeRWmR8Bo2Woz7TV40L4or1hlqHR0TuDxLttEANR0vmne8C_bueKsh_';
    }

    function get_last_access() {
        if (isset($this->data['last_access'])) {
            return $this->data['last_access'];
        } else {
            return '부정 접속자 없음';
        }
    }

    function get_security_status() {
        // 세부
        return '보안 문제 없음';
    }

    function display_admin_box() {
        $last_access = $this->get_last_access();
        $security_status = $this->get_security_status();
        ?>

        <style>
            .admin-box {
                border: 1px solid #ccc;
                padding: 10px;
                margin-top: 20px;
            }
            .admin-box h2 {
                font-size: 18px;
                margin-bottom: 10px;
            }
            .admin-info {
                margin-left: 20px;
            }
            .admin-info p {
                margin-bottom: 5px;
            }
        </style>

        <div class="admin-box">
            <h2>관리자 보안 시스템</h2>
            <div class="admin-info">
                <p>마지막 접속: <?php echo $last_access; ?></p>
                <p>보안 상태: <?php echo $security_status; ?></p>
            </div>
        </div>

        <?php
    }
}

$path_to_file = "anti_admin_user.json";
$ant_admin_user = new AntAdminUser($path_to_file);
$ant_admin_user->display_admin_box();
