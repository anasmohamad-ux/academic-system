import { createBrowserRouter } from "react-router-dom";

import LoginPage from "../modules/auth/pages/LoginPage";
import DashboardPage from "../modules/auth/pages/DashboardPage";

import MainLayout from "../shared/layouts/MainLayout";

import CoursesPage from "../modules/course/pages/CoursesPage";
import CreateCoursePage from "../modules/course/pages/CreateCoursePage";
import RegisterPage from "../modules/auth/pages/RegisterPage";
import ProtectedRoute from "../modules/auth/components/ProtectedRoute";
import MyCoursesPage from "../modules/course/pages/MyCoursesPage";
export const router = createBrowserRouter([
    {
        path: "/",
        element: <LoginPage />,
    },
    {
        path: "/register",
        element: <RegisterPage />,
    },
    {
        path: "/dashboard",
        element: (
            <ProtectedRoute>
                <MainLayout />
            </ProtectedRoute>
        ),
        children: [
            {
                index: true,
                element: <DashboardPage />,
            },
            {
                path: "courses",
                element: <CoursesPage />,
            },
            {
                path: "courses/create",
                element: <CreateCoursePage />,
            },
            {
                path: "my-courses",   // 🔥 ADD THIS
                element: <MyCoursesPage />,
            },

        ],
    },
]);
