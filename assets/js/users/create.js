/* script for create.php */
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("createUserForm");
  const feedback = document.getElementById("formFeedback");
  const submitBtn = form?.querySelector('button[type="submit"]');

  if (!form) return;

  // Helpers (like alerts and others)

  function showFeedback(message, type) {
    feedback.textContent = message;
    feedback.className = "alert alert-" + type;
  }

  function hideFeedback() {
    feedback.className = "alert hidden";
    feedback.textContent = "";
  }

  function showFieldError(inputId, message) {
    const input = document.getElementById(inputId);
    if (!input) return;

    const group = input.closest(".form-group");
    group?.classList.add("has-error");

    const span = document.createElement("span");
    span.className = "field-error";
    span.dataset.client = "1";
    span.textContent = message;
    group?.appendChild(span);
  }

  function clearErrors() {
    form
      .querySelectorAll(".field-error[data-client]")
      .forEach((el) => el.remove());
    form
      .querySelectorAll(".form-group.has-error")
      .forEach((el) => el.classList.remove("has-error"));
    hideFeedback();
  }

  function setLoading(loading) {
    if (!submitBtn) return;
    submitBtn.disabled = loading;
    submitBtn.textContent = loading ? "Saving..." : "Register User";
  }

  // Client-side validation

  function validate() {
    let valid = true;

    const name = document.getElementById("name")?.value.trim();
    const email = document.getElementById("email")?.value.trim();

    if (!name) {
      showFieldError("name", "Name is required.");
      valid = false;
    }

    if (!email) {
      showFieldError("email", "Email is required.");
      valid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showFieldError("email", "Enter a valid email address.");
      valid = false;
    }

    return valid;
  }

  // Submit logic

  form.addEventListener("submit", async function (e) {
    e.preventDefault();
    clearErrors();

    if (!validate()) return;

    setLoading(true);

    try {
      const response = await fetch(form.action, {
        method: "POST",
        headers: { "X-Requested-With": "XMLHttpRequest" },
        body: new FormData(form),
      });

      const data = await response.json();

      if (data.success) {
        showFeedback(
          data.message || "User registered successfully.",
          "success",
        );
        form.reset();

        if (data.redirect) {
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1200);
        }
      } else {
        showFeedback(data.message || "Something went wrong.", "error");

        if (data.errors && typeof data.errors === "object") {
          Object.entries(data.errors).forEach(([field, msg]) => {
            showFieldError(field, msg);
          });
        }
      }
    } catch (err) {
      showFeedback("Request failed: " + err.message, "error");
    } finally {
      setLoading(false);
    }
  });
});
