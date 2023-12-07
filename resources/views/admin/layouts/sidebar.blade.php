<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('admin') }}" class="nav-link @if (\Request::route()->getName() == 'admin') active @endif">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('category.index') }}" class="nav-link @if (\Request::route()->getName() == 'category.index') active @endif">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Category
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('question.index') }}" class="nav-link @if (\Request::route()->getName() == 'question.index') active @endif">
                        <i class="nav-icon fas fa-chart-pie"></i>
                        <p>
                            Question & Ans
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>