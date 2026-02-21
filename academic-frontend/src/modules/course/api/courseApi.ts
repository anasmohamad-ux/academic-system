import api from "@/shared/api/axios";
import type { Course } from "../types";


export const getCourses = async (): Promise<Course[]> => {
    const response = await api.get("/courses");
    return response.data;   // <-- MUST be this only
};
export const createCourse = async (
    data: Omit<Course, "id">
): Promise<Course> => {
    const response = await api.post("/courses", data);
    return response.data;
};

export const enrollInCourse = async (courseId: number) => {
    const response = await api.post("/enrollments", {
        course_id: courseId,
    });

    return response.data;
};

export const getMyCourses = async (): Promise<Course[]> => {
    const response = await api.get("/my-courses");
    return response.data;
};
export const cancelEnrollment = async (courseId: number) => {
    const response = await api.delete(`/enrollments/${courseId}`);
    return response.data;
};