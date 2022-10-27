<?php 

    class Image {
        public function vicinity() {
            $req = request()->inputs();
            echo <<<EOF
                <div style="width: 30px;height: 30px;border-radius:50%;
                    border:1px solid #000;text-align:center;
                    background-color:{$req['color']}">
                    <span style="line-height: 30px;font-weight:bold;color:#fff">{$req['text']}</span>
                </div>
            EOF;
        }

        public function index(){
            ?> 
                <div style="width: 30px;height: 30px;border-radius:50%;
                    border:1px solid #000;text-align:center;
                    background-color:red">
                    <span style="line-height: 30px;font-weight:bold;color:#fff">5</span>
                </div>
            <?php
        }
    }