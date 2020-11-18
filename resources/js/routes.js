import Dashboard from './components/Dashboard';
import Roles from './components/Roles';
import Users from './components/Users';
import Categories from './components/Categories';
import Expenses from './components/Expenses';
import Account from './components/Account';


export default {
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '/dashboard',
            component: Dashboard
        },
        {
            path: '/roles',
            component: Roles,
        },
        {
            path: '/users',
            component: Users,
        },
        {
            path: '/expense-categories',
            component: Categories
        },
        {
            path: '/expenses',
            component: Expenses,
        },
        {
            path: '/settings',
            component: Account,
        },
    ]
}
