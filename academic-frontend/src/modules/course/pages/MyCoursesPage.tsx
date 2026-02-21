import { useEffect, useState } from "react";
import CourseCard from "../components/CourseCard";
import { getMyCourses, cancelEnrollment } from "../api/courseApi";
import type { Course } from "../types";

const MyCoursesPage = () => {
    const [courses, setCourses] = useState<Course[]>([]);
    const [loadingId, setLoadingId] = useState<number | null>(null);

    useEffect(() => {
        const fetchMyCourses = async () => {
            const data = await getMyCourses();
            setCourses(Array.isArray(data) ? data : []);
        };

        fetchMyCourses();
    }, []);

    const handleCancel = async (courseId: number) => {
        try {
            setLoadingId(courseId);
            await cancelEnrollment(courseId);
            setCourses((prev) =>
                prev.filter((course) => course.id !== courseId)
            );
        } finally {
            setLoadingId(null);
        }
    };

    if (courses.length === 0)
        return <p>You are not enrolled in any courses.</p>;

    return (
        <div>
            <h1 className="text-3xl font-bold mb-6">My Courses</h1>

            <div className="grid grid-cols-3 gap-6">
                {courses.map((course) => (
                    <CourseCard
                        key={course.id}
                        course={course}
                        actionLabel="Cancel Enrollment"
                        loading={loadingId === course.id}
                        onAction={handleCancel}
                    />
                ))}
            </div>
        </div>
    );
};

export default MyCoursesPage;