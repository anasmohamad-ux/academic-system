import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import CourseCard from "../components/CourseCard";
import { getCourses, getMyCourses, enrollInCourse } from "../api/courseApi";
import type { Course } from "../types";
import { useAuth } from "../../auth/context/AuthContext";

const CoursesPage = () => {
    const { user } = useAuth();

    const [courses, setCourses] = useState<Course[]>([]);
    const [myCourses, setMyCourses] = useState<number[]>([]);
    const [loadingCourseId, setLoadingCourseId] = useState<number | null>(null);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const allCourses = await getCourses();
                setCourses(Array.isArray(allCourses) ? allCourses : []);

                if (user?.role === "student") {
                    const enrolledCourses = await getMyCourses();
                    setMyCourses(enrolledCourses.map((c) => c.id));
                }
            } catch (error) {
                console.error("Failed to fetch courses", error);
            }
        };

        fetchData();
    }, [user]);

    const handleEnroll = async (courseId: number) => {
        try {
            setLoadingCourseId(courseId);
            await enrollInCourse(courseId);
            setMyCourses((prev) => [...prev, courseId]);
        } catch (error: any) {
            if (error.response?.status !== 409) {
                alert("Something went wrong");
            }
        } finally {
            setLoadingCourseId(null);
        }
    };

    return (
        <div>
            {/* Header Section */}
            <div className="flex justify-between items-center mb-6">
                <h1 className="text-3xl font-bold">Courses</h1>

                {/* 🔥 Only Teacher */}
                {user?.role === "teacher" && (
                    <Link
                        to="/dashboard/courses/create"
                        className="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700"
                    >
                        + Create Course
                    </Link>
                )}
            </div>

            {/* Course Grid */}
            <div className="grid grid-cols-3 gap-6">
                {courses.map((course) => (
                    <CourseCard
                        key={course.id}
                        course={course}
                        actionLabel={
                            user?.role === "student"
                                ? myCourses.includes(course.id)
                                    ? "Enrolled"
                                    : "Enroll"
                                : undefined
                        }
                        disabled={
                            user?.role === "student"
                                ? myCourses.includes(course.id)
                                : true
                        }
                        loading={loadingCourseId === course.id}
                        onAction={
                            user?.role === "student"
                                ? handleEnroll
                                : undefined
                        }
                    />
                ))}
            </div>
        </div>
    );
};

export default CoursesPage;