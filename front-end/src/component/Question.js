import React, { useEffect, useState } from "react";
import { useLocation } from 'react-router-dom';
import axios from "axios";
import Swal from 'sweetalert2';
import { useNavigate } from 'react-router-dom'
import { API_BASE_URL } from './common/Constant';

const Question = () => {
    const navigate = useNavigate();

    const [question, setQuestion] = useState({
        question: '',
        answer: '',
        category_id: '',
    });

    const [category, setCategory] = useState([]);
    const [validationError, setValidationError] = useState({})
    const [isSubmitting, setIsSubmitting] = useState(false);

    const token = localStorage.getItem('token');
    const config = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'headers': { Authorization: `Bearer ${token}` }
    };

    useEffect(() => {
        if (!token) {
            navigate('/login');
        }
        const fetchData = async () => {
            await axios.get(`${API_BASE_URL}get_categories`, null, config).then(({ data }) => {
                setCategory(data.data);
            }).catch(({ response }) => {
                if (response.status === 422) {
                    alert(response.data.errors)
                } else {
                    Swal.fire({
                        text: response.data.message,
                        icon: "error"
                    })
                }
            })
        }

        fetchData();
    }, []);

    const handleChange = (e) => {
        const { name, value, type } = e.target;
        setQuestion({ ...question, [name]: value });
    };

    const handleSubmit = (event) => {
        event.preventDefault();
        setIsSubmitting(true);

        const formData = new FormData();
        formData.append('question', question.question);
        formData.append('category_id', question.category_id);
        formData.append('answer', question.answer);
    
        axios.post(`${API_BASE_URL}add_question`, formData, config)
            .then(function (response) {
                setQuestion({
                    question: '',
                    answer: '',
                    category_id: '',
                });
                
                Swal.fire({
                    icon: "success",
                    text: response.data.message
                });
                navigate("/login");
                setIsSubmitting(false);
            })
            .catch(({ response }) => {
                if (response.status === 422) {
                    setValidationError(response.data.errors)
                } else {
                    Swal.fire({
                        text: response.data.message,
                        icon: "error"
                    })
                }
                setIsSubmitting(false);
            })
    }    

    return (
        <>
            <div className="container mt-4">
                <div className="row justify-content-center">
                    <div className="col-md-6">
                        <div className="card p-4">
                            <h1 className="text-center mb-3">Add Question </h1>
                            {
                                Object.keys(validationError).length > 0 && (
                                    <div className="row">
                                        <div className="col-12">
                                            <div className="alert alert-danger">
                                                <ul className="mb-0">
                                                    {
                                                        Object.entries(validationError).map(([key, value]) => (
                                                            <li key={key}>{value}</li>
                                                        ))
                                                    }
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                )
                            }
                            <form onSubmit={handleSubmit}>
                                <div className="form-group">
                                    <label>Question:</label>
                                    <input type="text" name="question" className="form-control" placeholder="Enter question" value={question.name} onChange={handleChange} />
                                </div>
                                <div className="form-group">
                                    <label>Category:</label>
                                    <select className="form-control" name="category_id" onChange={handleChange}>
                                        <option value="">---Select Category---</option>
                                        {
                                            category.map((cat) => {
                                                return <option value={cat.id}>{cat.name}</option>
                                            })
                                        }
                                    </select>
                                </div>
                                <div className="form-group">
                                    <label>Answer:</label>
                                    <textarea name="answer" className="form-control" cols="30" rows="2" onChange={handleChange}>{question.answer}</textarea>
                                </div>
                                <button type="submit" className="btn btn-primary mt-4" disabled={isSubmitting}>
                                    {isSubmitting ? 'Submitting...' : 'Submit'}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </>
    )
}

export default Question;