export default async function handler(req, res) {
  const url = req.query.url;

  if (!url) {
    res.status(400).send("Missing ?url parameter");
    return;
  }

  try {
    const response = await fetch(url);
    const text = await response.text();

    res.setHeader("Access-Control-Allow-Origin", "*");
    res.setHeader("Content-Type", "text/plain");
    res.status(200).send(text);
  } catch (err) {
    res.status(500).send("Error fetching target URL: " + err);
  }
}
