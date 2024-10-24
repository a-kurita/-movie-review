import React, { useState } from 'react'
import { TextField, InputAdornment, Button, Box } from '@mui/material'
import SearchIcon from '@mui/icons-material/Search'
import { useRouter } from 'next/router'

export default function Search({ onSearch }) {
    const [query, setQuery] = useState('')
    const router = useRouter()

    const handleInputChange = event => {
        setQuery(event.target.value)
    }

    const handleSearchClick = e => {
        e.preventDefault()
        if (query) {
            router.push(`/search/${query}`)
        }
    }

    return (
        <div
            style={{
                width: '100%',
                display: 'flex',
                marginTop: '40px',
                justifyContent: 'center',
            }}>
            <Box
                sx={{
                    width: '80%',
                    display: 'flex',
                    justifyContent: 'center',
                    alignItems: 'center',
                    maxWidth: '500px',
                }}>
                <TextField
                    variant="outlined"
                    fullWidth
                    placeholder="映画タイトルを検索"
                    value={query}
                    onChange={handleInputChange}
                    InputProps={{
                        startAdornment: (
                            <InputAdornment position="start">
                                <SearchIcon />
                            </InputAdornment>
                        ),
                    }}
                />
                <Button
                    variant="contained"
                    sx={{
                        border: '1px solid #B5B5B5',
                        color: '#333333',
                        '&:hover': {
                            backgroundColor: '#A0A0A0',
                        },
                    }}
                    onClick={handleSearchClick}>
                    検索
                </Button>
            </Box>
        </div>
    )
}
