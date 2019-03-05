<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p>Alexander Pierce</p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    // ['label' => 'Menu Yii2', 'options' => ['class' => 'header']],
                    [
                        'label' => '工作区',
                        'icon' => 'circle-o',
                        'url' => 'javascript:;',
                        'items' => [
                            ['label' => '学员管理', 'icon' => 'circle-o', 'url' => ['/work-space/student/default/index']],
                            // ['label' => '报名统计', 'icon' => 'circle-o', 'url' => ['/vote-manager/entrance/default/index']],
                            ['label' => '卡券管理', 'icon' => 'circle-o', 'url' => ['/business/card/default/index']],
                            ['label' => '课程管理', 'icon' => 'circle-o', 'url' => ['/work-space/course/default/index']],
                            ['label' => '课程安排', 'icon' => 'circle-o', 'url' => ['/work-space/daily-course/default/index']],
                            ['label' => '常规管理', 'icon' => 'circle-o', 'url' => ['/work-space/config/default/index']],
                        ],
                    ],
                    // ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    // ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    // [
                    //     'label' => 'Some tools',
                    //     'icon' => 'share',
                    //     'url' => '#',
                    //     'items' => [
                    //         ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                    //         ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                    //         [
                    //             'label' => 'Level One',
                    //             'icon' => 'circle-o',
                    //             'url' => '#',
                    //             'items' => [
                    //                 ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                    //                 [
                    //                     'label' => 'Level Two',
                    //                     'icon' => 'circle-o',
                    //                     'url' => '#',
                    //                     'items' => [
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                         ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                    //                     ],
                    //                 ],
                    //             ],
                    //         ],
                    //     ],
                    // ],
                    [
                        'label' => '权限管理',
                        'icon' => 'fa fa-circle-o',
                        'url' => 'javascript:;',
                        'items' => [
                            ['label' => '路由管理', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/route']],
                            ['label' => '权限管理', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/permission']],
                            ['label' => '角色管理', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/role']],
                            ['label' => '用户与角色', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/assignment']],
                            ['label' => '菜单管理', 'icon' => 'fa fa-circle-o', 'url' => ['/admin/menu']],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
