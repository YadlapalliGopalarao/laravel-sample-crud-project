
<script setup>
defineProps({
    students: {
        type: Array,
        required: true
    }
})

const emit = defineEmits(['edit', 'delete'])
</script>

<template>
    <div class="table-card">

        <div class="section-heading">
            <div>
                <span class="eyebrow">DATABASE RECORDS</span>
                <h2>Student Records</h2>
                <p>Manage all registered students.</p>
            </div>

            <span class="record-count">
                {{ students.length }} Students
            </span>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>STUDENT NAME</th>
                        <th>EMAIL</th>
                        <th>CITY</th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="student in students"
                        :key="student.id"
                    >
                        <td>#{{ student.id }}</td>
                        <td class="student-name">
                            {{ student.name }}
                        </td>
                        <td>{{ student.email }}</td>
                        <td>
                            <span class="city-badge">
                                {{ student.city }}
                            </span>
                        </td>

                        <td class="action-buttons">
                            <button
                                class="btn-edit"
                                @click="emit('edit', student)"
                            >
                                Edit
                            </button>

                            <button
                                class="btn-delete"
                                @click="emit('delete', student.id)"
                            >
                                Delete
                            </button>
                        </td>
                    </tr>

                    <tr v-if="students.length === 0">
                        <td colspan="5" class="empty-state">
                            No student records found.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>
