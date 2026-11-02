/* ---------- conexión a supabase, la usan index, tabla, jugadores y usuarios ---------- */
const SUPABASE_URL = 'https://yjjcujmoaialawmzvdzq.supabase.co';
const SUPABASE_KEY = 'sb_publishable_8vbo3MfWiZR9Airj_BEe_Q_HXmYsBiH';
const db = supabase.createClient(SUPABASE_URL, SUPABASE_KEY);
