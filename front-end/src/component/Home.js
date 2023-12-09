import React, { useEffect, useState } from "react";
import { API_BASE_URL } from './common/Constant';
import axios from "axios";
import Spinner from './Spinner';

const Home = () => {
    const [questionAns, setQuestionAns] = useState([]);
    const [lastPage, setLastPage] = useState();
    const [currentPage, setCurrentPage] = useState(1);
    const [loading, setLoading] = useState(true);
    const [categories, setCategories] = useState([]);
    const [selectedCategory, setSelectedCategory] = useState('');
    const [selectedStartDate, setSelectedStartDate] = useState('');
    const [selectedEndDate, setSelectedEndDate] = useState('');
    const [showOwn, setShowOwn] = useState('');
    
    const token = localStorage.getItem('token');

    useEffect(() => {
        axios.get(`${API_BASE_URL}get_categories`)
            .then(({ data }) => {
                setCategories(data.data);
            })
            .catch(error => {
                console.error("Error fetching categories:", error);
            });
    }, [token]);

    const config = {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'headers': { Authorization: `Bearer ${token}` }
    };

    const fetchQuestionAns = async () => {
        setLoading(true);
        if(showOwn){
            var apiUrl = `${API_BASE_URL}get_question_ans_auth?page=${currentPage}&category_id=${selectedCategory}&date=${selectedStartDate}&show_own=${showOwn}`;
        } else{
            var apiUrl = `${API_BASE_URL}get_question_ans?page=${currentPage}&category_id=${selectedCategory}&date=${selectedStartDate}&show_own=${showOwn}`;
        }
        
        await axios.get(apiUrl, config)
            .then(({ data }) => {
                console.log(data.data.data);
                setQuestionAns(data.data.data);
                setLastPage(data.data.last_page);
                setCurrentPage(data.data.current_page);
                setLoading(false);
            })
            .catch(error => {
                console.error("Error fetching data:", error);
                setLoading(false);
            });
    };

    useEffect(() => {
        fetchQuestionAns();
    }, [currentPage, selectedCategory, selectedStartDate, selectedEndDate, showOwn]);

    const handleNextClick = () => {
        const nextPage = currentPage + 1;
        setCurrentPage(nextPage);
    };

    const handlePreClick = () => {
        const nextPage = currentPage - 1;
        setCurrentPage(nextPage);
    };

    const handleCategoryChange = (event) => {
        setSelectedCategory(event.target.value);
        setCurrentPage(1);
    };

    const handleStartDateChange = (event) => {
        setSelectedStartDate(event.target.value);
    };

    const handleClearFilters = () => {
        setSelectedCategory('');
        setSelectedStartDate('');
        setSelectedEndDate('');
        setCurrentPage(1);
    };

    const formatCreatedAtDate = (dateString) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
        });
    };

    const handleShowOwnChange = (event) => {
        if(event.target.checked){
            setShowOwn(1);
        } else{
            setShowOwn('');
        }
        setCurrentPage(1);
    };

    return (
        <>
            <div className="container mt-4">
                <div className="row">
                    <div className="col-md-12">
                        <div className="row mb-3">
                            <div className="col-md-3">
                                <label htmlFor="categoryFilter" className="form-label">Filter by Category:</label>
                                <select
                                    className="form-control"
                                    id="categoryFilter"
                                    value={selectedCategory}
                                    onChange={handleCategoryChange}
                                >
                                    <option value="">All Categories</option>
                                    {categories.map((category) => (
                                        <option key={category.id} value={category.id}>
                                            {category.name}
                                        </option>
                                    ))}
                                </select>
                            </div>
                            <div className="col-md-3">
                                <label htmlFor="startDate" className="form-label">Filter by Date:</label>
                                <input
                                    type="date"
                                    className="form-control"
                                    id="startDate"
                                    value={selectedStartDate}
                                    onChange={handleStartDateChange}
                                />
                            </div>
                            <div className="col-md-3 d-flex align-items-end">
                                <button
                                    type="button"
                                    className="btn btn-secondary"
                                    onClick={handleClearFilters}
                                >
                                    Clear All Filters
                                </button>
                            </div>

                            {
                                localStorage.getItem('token') ? (
                                    <div className="col-md-3 d-flex align-items-end">
                                        <div className="form-check form-switch">
                                            <input
                                                className="form-check-input"
                                                type="checkbox"
                                                id="showOwn"
                                                checked={showOwn}
                                                onChange={handleShowOwnChange}
                                            />
                                            <label className="form-check-label" htmlFor="showOwn">
                                                Show Own
                                            </label>
                                        </div>
                                    </div>
                                ) : ''
                            }

                        </div>
                        {loading ? (
                            <Spinner />
                        ) : (
                            questionAns.length > 0 ? (
                                questionAns.map((row, key) => (
                                    <div className="card mb-4" key={key}>
                                        <div className="card-body">
                                            <h5 className="card-title">Q: {row.question}</h5>
                                            {row.get_answer.map((ans, ansKey) => (
                                                <p className="card-text" key={ansKey}><strong>A:</strong> {ans.answer}</p>
                                            ))}
                                            <div className="d-flex justify-content-between">
                                                <button type="button" className="btn btn-info btn-sm">Added On - {formatCreatedAtDate(row.created_at)}</button>
                                                <button type="button" className="btn btn-info btn-sm">Added by - {row.get_user.name}</button>
                                            </div>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="alert alert-info" role="alert">
                                    No records found.
                                </div>
                            )
                        )}
                        <div className="text-center mb-5">
                            <button
                                type="button"
                                className="btn btn-primary mx-2"
                                onClick={handlePreClick}
                                disabled={currentPage > 1 ? false : true}
                            >
                                Previous
                            </button>
                            <button
                                type="button"
                                className="btn btn-primary mx-2"
                                onClick={handleNextClick}
                                disabled={currentPage < lastPage ? false : true}
                            >
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default Home;
